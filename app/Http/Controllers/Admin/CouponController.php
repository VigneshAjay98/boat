<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DataTables;

use App\Http\Interfaces\CouponRepositoryInterface;
use App\Http\Requests\SaveCouponRequest;

use App\Models\Coupon;
use \Stripe\Stripe;

class CouponController extends Controller
{

    private $couponRepository;

	public function __construct(CouponRepositoryInterface $couponRepository) {
		$this->couponRepository = $couponRepository;
	}

    /**
	 * Display a listing of coupons.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.coupons.index');
	}

    /**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.coupons.coupon-form');
	}

    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Coupon $coupon)
	{
		return view('admin.coupons.coupon-form', compact('coupon'));
	}

    /**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(SaveCouponRequest $request)
	{
		$validator = $request->validated();
		$coupon = $this->couponRepository->create($validator);
		if ($coupon) {
			//we need to push data to stripe
			$key = \config('services.stripe.secret');
			$stripe = new \Stripe\StripeClient($key);
            $totalAmount = (isset($request->amount))? $request->amount: 0;
            $couponStripe = false;
			if($request->type == "percentage"){
				$couponStripe = $stripe->coupons->create([
					'name' => $request->code,
					'percent_off' => $totalAmount ?? 0,
					'duration' => 'forever'
				]);
			}
			if($request->type == "fixed"){
				$couponStripe = $stripe->coupons->create([
					'name' => $request->code,
					'currency' => 'USD',
					'amount_off' => ($totalAmount ?? 0)*100,
					'duration' => 'forever'
				]);
			}

			if($couponStripe){
				$coupon->stripe_coupon_id = $couponStripe->id;
				$coupon->save();
			}



			$this->success('Coupon added successfully!')->push();
			return redirect('/admin/coupons');
		} else {
			$this->error('Failed to add coupon!')->push();
			return view('admin.coupons.coupon-form');
		}
	}

    /**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(SaveCouponRequest $request, Coupon $coupon)
	{
		$validator = $request->validated();
		$coupon = $this->couponRepository->update($coupon, $validator);
		if ($coupon) {
			$this->success('Coupon updated successfully!')->push();
		} else {
			$this->error('Failed to update coupon!')->push();
		}

		return redirect('/admin/coupons');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Coupon $coupon)
	{
		$statusType = 'error';
		$status = 422;
		if (!empty($coupon)) {
			try {

				if($coupon->stripe_coupon_id){
					$key = \config('services.stripe.secret');
					$stripe = new \Stripe\StripeClient($key);
					$stripe->coupons->delete($coupon->stripe_coupon_id, []);
				}

				$coupon = $this->couponRepository->delete($coupon);
                if ($coupon) {

                    $this->success('Coupon deleted successfully!')->push();
                    $statusType = 'success';
                    $status = 200;
                }
			} catch (\Exception $exception) {
				$statusType = $exception->getMessage();
				$this->error('Coupon does not found! Please try again')->push();
			}
		}
		return response()->json(['status' => $statusType], $status);
	}

    /**
	 * This function provide coupons listings for data table
	 *
	 * @param  int  $request
	 * @return \Illuminate\Http\Response
	 */

	 public function couponsList(Request $request) {
		if ($request->ajax()) {
			$coupons = Coupon::all();
			return Datatables::of($coupons)
				->addIndexColumn()
                ->addColumn('amount', function($coupon){
					if($coupon->type == 'percentage'){
                        return $coupon->amount.'%';
                    }elseif($coupon->type == 'fixed'){
                        return '$'.$coupon->amount;
                    }else{
                        return 'NA';
                    }
				})
                ->addColumn('expiry_date', function($coupon){
					if(isset($coupon->expiry_date)){
                        return $coupon->expiry_date;
                    }
                    return 'Lifetime';
				})
				->addColumn('action', function($coupon){
					$actionBtn = '<a href="'.url('/admin/coupons').'/'.$coupon->id.'" class="delete  text-danger delete-confirmation" data-redirect-url="'.url('/admin/coupons').'"><i class="bi bi-trash-fill"></i></a>';

					// <a href="'.url("/admin/coupons/".$coupon->id."/edit").'"><i class="bi bi-pencil-square"></i></a>
					return $actionBtn;
				})
				->rawColumns(['action'])
				->make(true);
		}
	}
}
