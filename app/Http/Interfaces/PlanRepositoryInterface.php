<?php

namespace App\Http\Interfaces;

use App\Models\Plan;

interface PlanRepositoryInterface
{
	/**
	 * Get all plans
	 *
	 * @param int
	 */
	public function get();

	/**
	 * Get a plan by it's UUID
	 *
	 * @param int
	 */
	public function getByUuid($uuid);

    /**
	 * Get a plan by it's slug
	 *
	 * @param int
	 */
	public function getBySlug($slug);

	public function getPlan($boatId);

	public function getPackageAddOns($boatId, $planId);

	public function storeUserPlanAddon(array $planBasicData, array $addonData, $isValidCoupon, $couponCode);
    
}
