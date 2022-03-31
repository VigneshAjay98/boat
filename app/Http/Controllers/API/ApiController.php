<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests\RegisterUserApiRequest;
use App\Http\Requests\StoreOrderTransactionApiRequest;

use App\Models\OrderTransaction;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\User;

class ApiController extends Controller
{

    /**
     * This function is use to get login user information
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $response = ['status' => 'error'];
        $responseStatus = 422;
        if ($request->input('email') && $request->input('password')) {
            $user = User::whereEmail($request->input('email'))->first();

            if ($user && Hash::check($request->input('password'), $user->password)) {
                $response = [
                    'status' => 'success',
                    'username' => $user->email,
                    'full_name' => $user->full_name,
                    'api_token' => 'agdgs348927849723942389483298598'
                ];
                $responseStatus = 200;
            }
        }
        return response()->json($response, $responseStatus);
    }

    /**
     * This function is use for user registration
     *
     * @param Request $request
     * @return void
     */
    public function registration(RegisterUserApiRequest $request)
    {
        $response = ['status' => 'error'];
        $responseStatus = 422;
        try{
            $validator = $request->validated();
            if( isset($validator) && !empty($validator)){
                $user = User::whereEmail($validator['email'])->first();
                if (empty($user)) {
                    $user = new User();
                    $user->uuid = (string) Str::uuid();
                    $user->email = $validator['email'];
                    $user->password = Hash::make($validator['password']);
                    $user->contact_number = $validator['contact_number'] ?? null;
                    $user->first_name =  $validator['first_name'];
                    $user->last_name =  $validator['last_name'] ?? null;
                    $user->address = $validator['address'] ?? null;
                    $user->city = $validator['city'] ?? null;
                    $user->country = $validator['country'] ?? null;
                    $user->state =  $validator['state'] ?? null;
                    $user->zip_code =  $validator['zip_code'] ?? null;
                    $user->role =  'user';
                    if($user->save()){
                        $response = ['status' => 'success'];
                        $responseStatus = 200;
                    }
                }
            }
        } catch (\Exception $exception) {
            $response = ['status' => 'error'];
            $responseStatus = 422;
        }
        return response()->json($response, $responseStatus);
    }

    /**
     * This function is use to add user's boat information
     *
     * @param Request $request
     * @return void
     */
    public function addOrderTransactions(StoreOrderTransactionApiRequest $request)
    {
        $response = ['status' => 'error'];

        $responseStatus = 422;
        try{
            $validator = $request->validated();
            if( isset($validator) && !empty($validator)){
                $transaction = new OrderTransaction();
                $transaction->order_date = $validator['order_date'] ?? null;
                $transaction->status = $validator['status'] ?? 'pending';
                $transaction->order_id = $validator['order_id'] ?? null;
                $transaction->user_id =  $validator['user_id'] ?? null;
                $transaction->payment_type =  $validator['payment_type'];
                $transaction->transaction_id = $validator['transaction_id'] ?? null;
                $transaction->stripe_customer_id = $validator['stripe_customer_id'] ?? null;
                $transaction->stripe_payment_id = $validator['stripe_payment_id'] ?? null;
                $transaction->order_total =  $validator['order_total'];
                if($transaction->save()){
                    $response = ['status' => 'success'];
                    $responseStatus = 200;
                }
            }
        } catch (\Exception $exception) {
            $response = ['status' => 'error'];
            $responseStatus = 422;
        }
        return response()->json($response, $responseStatus);

    }

    /**
     * This function is use to add user's boat information
     *
     * @param Request $request
     * @return void
     */
    public function addBoat(Request $request)
    {

    }

    /**
     * This function is use to get all the active models of the brand
     *
     *
     * @return void
     */
    public function getModelsListing($brandSlug)
    {
        $models = '';
        $brand = Brand::select('id')->whereSlug($brandSlug)->first();
        if (!empty($brand)) {
            $models = BrandModel::whereBrandId($brand->id)->isActive()->pluck('model_name', 'slug');
        }
        return response()->json($models);
    }

}
