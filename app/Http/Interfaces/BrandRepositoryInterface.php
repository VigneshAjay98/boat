<?php

namespace App\Http\Interfaces;

use App\Models\Brand;

interface BrandRepositoryInterface
{
	/**
	 * Get all brands
	 *
	 * @param int
	 */
	public function get();

    /**
	 * Get all active status brands
	 *
	 * @param int
	 */
	public function getActiveBrands();

	/**
	 * Get a brand by it's UUID
	 *
	 * @param int
	 */
	public function getByUuid($uuid);

    /**
	 * Get a brand by it's slug
	 *
	 * @param int
	 */
	public function getBySlug($slug);

	/**
	 * Create new brand.
	 *
	 * @param array
	 */
	public function create(array $brandData);

	/**
	 * Updates a brand.
	 *
	 * @param int
	 * @param array
	 */
	public function update(Brand $brand, array $brandData);

    /**
	 * Updates brand status.
	 *
	 * @param int
	 * @param array
	 */
	public function status(Brand $brand, $status);


    /**
	 * Delete a brand.
	 *
	 * @param int
	 * @param array
	 */
	public function delete(Brand $brand);

}
