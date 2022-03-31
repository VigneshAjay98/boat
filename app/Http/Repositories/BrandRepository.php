<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Interfaces\BrandRepositoryInterface;

use App\Models\Brand;

class BrandRepository implements BrandRepositoryInterface
{
    /**
     * get a Brand
     * @param string
     * @return collection
     */
    public function get()
    {
        return Brand::all();
    }

     /**
     * get a Brand by it's UUID
     * @param string
     * @return collection
     */
    public function getActiveBrands()
    {
        return Brand::where('is_active','Y')->orderBy('name')->get();
    }
    /**
     * get a Brand by it's UUID
     * @param string
     * @return collection
     */
    public function getByUuid($uuid)
    {
        return Brand::where('uuid',$uuid)->first();
    }

    /**
	 * Get a brand by it's slug
	 *
	 * @param int
	 */
	public function getBySlug($slug)
    {
        return Brand::where('slug',$slug)->first();
    }

    /**
     * Create new brand.
     * @param array Brand data
     */
    public function create(array $brandData)
    {
        $brand = new Brand();
        try {
            $brand->name = $brandData['name'];
            $brand->description = $brandData['description'];
            $brand->save();
            return $brand;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
    /**
     * Updates existing brand.
     *
     * @param Brand object
     * @param array Brand data
     */
    public function update(Brand $brand, array $brandData)
    {
        try {
            $brand->name = $brandData['name'];
            $brand->description = $brandData['description'];
            $brand->save();
            return $brand;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

 /**
	 * Updates brand status.
	 *
	 * @param int
	 * @param array
	 */
	public function status(Brand $brand, $status){
        try {
            $brand->is_active =  ($status == 'N') ? 'Y' : 'N';
            $brand->save();
            return $brand;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
	 * Delete a brand.
	 *
	 * @param int
	 * @param array
	 */
	public function delete(Brand $brand){
        DB::beginTransaction();
		try {
			$brand->delete();
		} catch (\Exception $exception) {
			DB::rollBack();
			throw $exception;
		}
		DB::commit();
		return $brand;
    }

}
