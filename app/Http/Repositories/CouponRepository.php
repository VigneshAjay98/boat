<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;

use App\Http\Interfaces\CouponRepositoryInterface;

use App\Models\Coupon;

class CouponRepository implements CouponRepositoryInterface
{
    /**
     * get a Coupon
     * @param string
     * @return collection
     */
    public function get()
    {
        return Coupon::all();
    }

    /**
     * Create new coupon.
     * @param array Coupon data
     */
    public function create(array $couponData)
    {
        $coupon = new Coupon();
        try {
            $coupon->code = $couponData['code'];
            $coupon->type = $couponData['type'];
            $coupon->amount = ($couponData['type'] != 'free') ? $couponData['amount'] : null;
            // $coupon->stripe_coupon_id = $couponData['stripe_coupon_id'] ?? null;
            $coupon->expiry_date = $couponData['expiry_date'] ?? null;
            $coupon->save();
            return $coupon;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
    /**
     * Updates existing coupon.
     *
     * @param Coupon object
     * @param array Coupon data
     */
    public function update(Coupon $coupon, array $couponData)
    {
        try {
            $coupon->code = $couponData['code'];
            $coupon->type = $couponData['type'];
            $coupon->amount = ($couponData['type'] != 'free') ? $couponData['amount'] : null;
            // $coupon->stripe_coupon_id = $couponData['stripe_coupon_id'] ?? null;
            $coupon->expiry_date = $couponData['expiry_date'] ?? null;
            $coupon->save();
            return $coupon;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
	 * Delete a coupon.
	 *
	 * @param int
	 * @param array
	 */
	public function delete(Coupon $coupon){
        DB::beginTransaction();
		try {
			$coupon->delete();
		} catch (\Exception $exception) {
			DB::rollBack();
			throw $exception;
		}
		DB::commit();
		return $coupon;
    }

}


