<?php

namespace App\Http\Interfaces;

use App\Models\Option;

interface OptionRepositoryInterface
{
	/**
	 * Get's all models 
	 *
	 * @param int
	 */
	public function get();

	/**
	 * Get's a model by it's UUID
	 *
	 * @param int
	 */
	public function getByUuid($uuid);

	/**
	 * Create new model.
	 *
	 * @param array
	 */
	public function create(array $optionData);

	/**
	 * Updates a option.
	 *
	 * @param int
	 * @param array
	 */
	public function update(Option $option, array $optionData);

}