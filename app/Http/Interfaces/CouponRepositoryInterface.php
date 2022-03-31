<?php

namespace App\Http\Interfaces;

use App\Models\Coupon;

interface CouponRepositoryInterface
{
	/**
	 * Get all coupons
	 *
	 * @param int
	 */
	public function get();

	/**
	 * Create new coupon.
	 *
	 * @param array
	 */
	public function create(array $couponData);

	/**
	 * Updates a coupon.
	 *
	 * @param int
	 * @param array
	 */
	public function update(Coupon $coupon, array $couponData);

    /**
	 * Delete a coupon.
	 *
	 * @param int
	 * @param array
	 */
	public function delete(Coupon $coupon);

}
