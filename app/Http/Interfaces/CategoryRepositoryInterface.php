<?php

namespace App\Http\Interfaces;

use App\Models\Category;
use App\Models\ActivityCategory;

interface CategoryRepositoryInterface
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
	 * Get a category by it's slug
	 *
	 * @param int
	 */
	public function getBySlug($slug);

	/**
	 * Create new model.
	 *
	 * @param array
	 */
	public function create(array $categoryData);

	/**
	 * Updates a option.
	 *
	 * @param int
	 * @param array
	 */
	public function update(Category $category, array $categoryData);

}
