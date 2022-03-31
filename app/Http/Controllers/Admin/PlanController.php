<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Stripe\Stripe;

use DataTables;

use App\Models\Plan;
use App\Models\PlanAddon;


use App\Http\Requests\SavePlanRequest;

class PlanController extends Controller
{

     /**
	 * Display a listing of plans.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.plans.index');
	}

    /**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.plans.plan-form');
	}

    /**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(SavePlanRequest $request)
	{
		$validator = $request->validated();
        $plan = new Plan();
        $plan->name = $validator['name'];
        $plan->price = $validator['price'];
        $plan->duration_weeks = $validator['duration_weeks'] ??  null;
        $plan->image_number = $validator['image_number'] ?? null;
        $plan->video_number = $validator['video_number'] ?? null;

        try{
        	$key = \config('services.stripe.secret');
			$stripe = new \Stripe\StripeClient($key);




			if ($plan->save()) {
				$productInfo = $stripe->products->create([
				  'name' => $request->name,
				  'description' => 'YachtFindr-'.$request->name
				]);
				$priceOptions = [
	                'currency' => 'usd',
	                'product' => $productInfo->id,
	                'unit_amount' => ($request->price) * 100,
	                'nickname' => $request->name
	            ];
                if(isset($request->duration_weeks)){
                    $priceOptions['recurring'] = [
	                    'interval' => 'week',
	                    'interval_count' => $request->duration_weeks,
	                ];
                }
				$plansProductPrice = $stripe->prices->create($priceOptions);
				$plan->stripe_price_id = $plansProductPrice->id;
				$plan->stripe_product_id = $productInfo->id;
				$plan->save();

				$this->success('Plan added successfully!')->push();
				return redirect('/admin/plans');

			}
        }
        catch(\Exception $ex){
        	print_r($ex->getMessage());
			// $this->error($ex->getMessage())->push();
			// return view('admin.plans.plan-form');
        }

	}


    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Plan $plan)
	{
		return view('admin.plans.plan-form', compact('plan'));
	}

    /**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(SavePlanRequest $request, Plan $plan)
	{
		$validator = $request->validated();
		$plan->name = $validator['name'];
        $plan->price = $validator['price'];
        $plan->duration_weeks = $validator['duration_weeks'] ??  null;
        // $plan->stripe_price_id = $validator['stripe_price_id'] ?? null;
        // $plan->stripe_product_id = $validator['stripe_product_id'] ?? null;
        $plan->image_number = $validator['image_number'] ?? null;
        $plan->video_number = $validator['video_number'] ?? null;
		if ($plan->save()) {
			$this->success('Plan updated successfully!')->push();
		} else {
			$this->error('Failed to update plan!')->push();
		}

		return redirect('/admin/plans');
	}

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Plan $plan)
	{
		$statusType = 'error';
		$status = 422;
		if (!empty($plan)) {
            $planAddons  = [];
            $planAddons = PlanAddon::where('plan_id', $plan->id)->get();
            if(!count($planAddons) > 0){
                try {
                    // if($plan->stripe_product_id){
                    //     $key = \config('services.stripe.secret');
                    //     $stripe = new \Stripe\StripeClient($key);
                    //     $stripe->products->delete($plan->stripe_product_id, []);
                    // }
                    $allPlans = Plan::all();
                    if(count($allPlans) == 1) {
                    	Plan::truncate();
                    }else {
                    	$plan->delete();
                    }

                    $this->success('Plan deleted successfully!')->push();
                    $statusType = 'success';
                    $status = 200;
                } catch (\Exception $exception) {
                    $statusType = 'error';
                    $status = 422;
                    $this->error($exception->getMessage())->push();
                }
            }else{
                $statusType = 'error';
                $status = 422;
                $this->error('Plan already assigned to addons. To delete this plan, delete all addons related to this plan!')->push();
            }
		}else{
            $this->error('Plan does not found! Please try again')->push();
        }
		return response()->json(['status' => $statusType], $status);
	}

    /**
     * Change status from plans listing
     *
     * @param [type] $uuid
     * @return void
    */
  public function status($uuid)
  {
    $plan = Plan::whereUuid($uuid)->first();
    if ($plan) {
        $plan->is_video_allowed = ($plan->is_video_allowed == 1) ? 0 : 1;
        if($plan->save()){
            $status = 'success';
            $message = 'Plan video allowed status updated successfully!';
            $code = 200;
        } else {
            $status = 'success';
            $message = 'Plan does not found! Please try again later';
            $code = 422;
    }
        return response()->json([
            'status' => $status,
            'message' => $message
        ], $code);
    }else{
        return response()->json([
            'status' => 'error',
            'message' => 'Plan does not found! Please try again later'
        ], 422);
    }
  }



     /**
	 * This function provide plans listings for data table
	 *
	 * @param  int  $request
	 * @return \Illuminate\Http\Response
	 */

	 public function plansList(Request $request) {
		if ($request->ajax()) {
			$plans = Plan::all();
			return Datatables::of($plans)
				->addIndexColumn()
                ->addColumn('price', function($plan){
					if(isset($plan->price)){
                        return '$'.$plan->price;
                    }else{
                        return 'NA';
                    }
				})
                ->addColumn('duration_weeks', function($plan){
					if(isset($plan->duration_weeks)){
                        return $plan->duration_weeks;
                    }
                    return 'Lifetime';
                    //return $plan->duration_weeks;
				})
                ->addColumn('image_number', function($plan){
					if(isset($plan->image_number)){
                        return $plan->image_number;
                    }
                    return 'Unlimited';
				})
                ->addColumn('video_number', function($plan){
                    if(isset($plan->video_number)){
                        return $plan->video_number;
                    }
                    return '-';
				})
				->addColumn('action', function($plan){
					$actionBtn = '<a href="'.url("/admin/plans/".$plan->uuid."/edit").'"><i class="bi bi-pencil-square"></i></a> <a href="'.url('/admin/plans').'/'.$plan->uuid.'" class="delete  text-danger delete-confirmation" data-redirect-url="'.url('/admin/plans').'"><i class="bi bi-trash-fill"></i></a>';
					return $actionBtn;
				})
				->rawColumns(['price', 'duration_weeks', 'image_number', 'video_number', 'action'])
				->make(true);
		}
	}

}
