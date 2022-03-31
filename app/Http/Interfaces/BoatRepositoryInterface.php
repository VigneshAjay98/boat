<?php

namespace App\Http\Interfaces;

use App\Models\Boat;

interface BoatRepositoryInterface
{
	/**
	 * Get all boats
	 *
	 * @param int
	 */
	public function get();

	/**
	 * Get a boat by it's UUID
	 *
	 * @param int
	 */
	public function getByUuid($uuid);

    /**
     * get all boat cities
     * @param string
     * @return collection
     */
    public function getAllCities();

    /**
	 * Get a boat by brand id and model name
	 *
	 * @param int
	 */
	public function getByModelAndBrandId($modelName, $brandId);

	/**
	 * Save new boat
	 *
	 * @param int
	 */
	public function saveUserBoat($subscriptionId);

    /**
	 * Get boats information by slug
	 *
	 * @param int
	 */
	public function getBySlug($slug);

	/**
	 * Create new boat.
	 *
	 * @param array
	 */
	public function create(array $boatData);

	/**
	 * Updates a boat.
	 *
	 * @param int
	 * @param array
	 */
	public function update(Boat $boat, array $boatData);

    /**
	 * Updates boat status.
	 *
	 * @param int
	 * @param array
	 */
	public function status(Boat $boat, $status);


    /**
	 * Delete a boat.
	 *
	 * @param int
	 * @param array
	 */
	public function delete(Boat $boat);

}
