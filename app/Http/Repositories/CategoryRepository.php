<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Interfaces\CategoryRepositoryInterface;

use App\Models\Option;
use App\Models\Category;
use App\Models\ActivityCategory;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * get a Category
     * @param string
     * @return collection
     */
    public function get()
    {
        return Category::all();
    }

    /**
     * get a Category by it's UUID
     * @param string
     * @return collection
     */
    public function getByUuid($uuid)
    {
        return Category::byUuid($uuid)->first();
    }

    /**
	 * Get a category by it's slug
	 *
	 * @param int
	 */
	public function getBySlug($slug)
    {
        return Category::where('slug',$slug)->first();
    }


    public function getBoatTypeCategories($boatType) {
        return Category::where('boat_type', $boatType)->where('is_active', 'Y')->orderBy('name')->get();
    }

    public function getFirstTypeCategories() {
        $boatType = Option::where('option_type','boat_type')->where('is_active', 'Y')->first();
        return Category::where('boat_type', $boatType->name)->where('is_active', 'Y')->orderBy('name')->get();
    }


    public function getOptionId($uuid) {
        $option = Option::where('uuid', $uuid)->first();

        return $option->id;
    }
    /**
     * Create new User.
     * @param array User data
     */
    public function create(array $categoryData)
    {
        $category = new Category();
        try {
            $category->name = $categoryData['name'];
            $category->description = $categoryData['description'];
            $category->boat_type = $categoryData['boat_type'];
            $category->other_info = $categoryData['other_information'];
            $category->save();

            $activityCategory = new ActivityCategory();
            $activityCategory->category_id  = $category->id;
            $activityCategory->option_id  = $this->getOptionId($categoryData['activity']);
            $activityCategory->save();
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
    /**
     * Updates existing Category.
     *
     * @param Category object
     * @param array Category data
     */
    public function update(Category $category, array $categoryData)
    {
        try {
            $category->name = $categoryData['name'];
            $category->description = $categoryData['description'];
            $category->boat_type = $categoryData['boat_type'];
            $category->other_info = $categoryData['other_information'];
            $category->save();

            $activityCategory = ActivityCategory::where('category_id', $category->id)->first();
            $activityCategory->option_id  = $this->getOptionId($categoryData['activity']);
            $activityCategory->save();
            return true;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Change status of option.
     * @param Option object
     */
    public function changeStatus(Category $category)
    {
        try {
            $category->is_active = ($category->is_active == 'N') ? 'Y' : 'N';
            $category->save();
            return $category;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Delete a Category.
     * @param Category object
     */
    public function delete(Category $category)
    {
        try {
            return $category->delete() ? true : false;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

}
