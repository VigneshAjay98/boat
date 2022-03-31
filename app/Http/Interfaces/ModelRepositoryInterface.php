<?php

namespace App\Http\Interfaces;

use App\Models\BrandModel;

interface ModelRepositoryInterface
{
	/**
	 * Get all models
	 *
	 * @param int
	 */
	public function get();

	/**
	 * Get a model by it's UUID
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
	 * Create new model.
	 *
	 * @param array
	 */
	public function create(array $modelData);

	/**
	 * Updates a model.
	 *
	 * @param int
	 * @param array
	 */
	public function update(BrandModel $model, array $modelData);

    /**
	 * Updates model status.
	 *
	 * @param int
	 * @param array
	 */
	public function status(BrandModel $model, $status);


    /**
	 * Delete a model.
	 *
	 * @param int
	 * @param array
	 */
	public function delete(BrandModel $model);

}
