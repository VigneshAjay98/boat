<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Stripe\Stripe;

use DataTables;

use App\Models\PlanAddon;
use App\Models\Plan;

use App\Http\Requests\SavePlanAddonRequest;

class PlanAddonController extends Controller
{
     /**
	 * Display a listing of plans addon.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.plan-addons.index');
	}

    /**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
        $plans = Plan::all();
		return view('admin.plan-addons.plan-addon-form', compact('plans'));
	}

    /**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(SavePlanAddonRequest $request)
	{
		$validator = $request->validated();
        $addon = new PlanAddon();
        $addon->plan_id = $validator['plan_id'];
        $addon->addon_name = $validator['addon_name'];
        $addon->addon_cost = $validator['addon_cost'];
        // $addon->stripe_price_id = $validator['stripe_price_id'] ?? null;
		if ($addon->save()) {
			$key = \config('services.stripe.secret');
			$stripe = new \Stripe\StripeClient($key);
			$plan = Plan::find($request->plan_id);
			$priceOptions = [
                'currency' => 'usd',
                'product' => $plan->stripe_product_id,
                'unit_amount' => ($request->addon_cost) * 100,
                'nickname' => $request->addon_name,
            ];

            if(isset($plan->duration_weeks)){
                $priceOptions['recurring'] = [
                    'interval' => 'week',
                    'interval_count' => $plan->duration_weeks,
                ];
            }

			$plansProductPrice = $stripe->prices->create($priceOptions);
			$addon->stripe_price_id = $plansProductPrice->id;
			$addon->save();


			$this->success('Plan addon added successfully!')->push();
			return redirect('/admin/plan-addons');

		} else {
			$this->error('Failed to add plan\'s addon!')->push();
			return view('admin.plan-addons.plan-addon-form');
		}
	}

    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($uuid)
	{
        $addon = PlanAddon::whereUuid($uuid)->first();
        $plans = Plan::all();
		return view('admin.plan-addons.plan-addon-form', compact('addon', 'plans'));
	}

   /**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(SavePlanAddonRequest $request, PlanAddon $addon)
	{
		$validator = $request->validated();
        $addon->plan_id = $validator['plan_id'];
        $addon->addon_name = $validator['addon_name'];
        $addon->addon_cost = $validator['addon_cost'];
        // $addon->stripe_price_id = $validator['stripe_price_id'] ?? null;
		if ($addon->save()) {
			$this->success('Plan addon updated successfully!')->push();
		} else {
			$this->error('Failed to update plan addon!')->push();
		}

		return redirect('/admin/plan-addons');
	}

    /**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($uuid)
	{
        $addon = PlanAddon::whereUuid($uuid)->first();
		$statusType = 'error';
		$status = 422;
		if (!empty($addon)) {
			try {
                // if($addon->stripe_price_id){
                //     $key = \config('services.stripe.secret');
                //     $stripe = new \Stripe\StripeClient($key);

                //     $stripe->prices->delete($addon->stripe_price_id, []);
                // }
                if ($addon->delete()) {
                    $this->success('Plan addon deleted successfully!')->push();
                    $statusType = 'success';
                    $status = 200;
                }
			} catch (\Exception $exception) {
                $statusType = 'error';
                $status = 422;
				$message = $exception->getMessage();
				$this->error($message)->push();
			}
		}else{
            $statusType = 'error';
		    $status = 422;
            $this->error('Plan addon does not found! Please try again')->push();
        }
		return response()->json(['status' => $statusType], $status);
	}

     /**
	 * This function provide plans listings for data table
	 *
	 * @param  int  $request
	 * @return \Illuminate\Http\Response
	 */

	 public function planAddonsList(Request $request) {
		if ($request->ajax()) {
			$addons = PlanAddon::all();
			return Datatables::of($addons)
				->addIndexColumn()
                ->addColumn('plan_name', function($addon){
					return $addon->plan->name;
				})
                ->addColumn('addon_cost', function($addon){
					if(isset($addon->addon_cost)){
                        return '$'.$addon->addon_cost;
                    }else{
                        return 'NA';
                    }
				})
				->addColumn('action', function($addon){
					$actionBtn = '<a href="'.url("/admin/plan-addons/".$addon->uuid."/edit").'"><i class="bi bi-pencil-square"></i></a> <a href="'.url('/admin/plan-addons').'/'.$addon->uuid.'" class="delete  text-danger delete-confirmation" data-redirect-url="'.url('/admin/plan-addons').'"><i class="bi bi-trash-fill"></i></a>';
					return $actionBtn;
				})
				->rawColumns(['plan_name', 'action'])
				->make(true);
		}
	}
}
