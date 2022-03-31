<?php

namespace App\Http\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Interfaces\ModelRepositoryInterface;

use App\Models\BrandModel;

class ModelRepository implements ModelRepositoryInterface
{
    /**
     * get a Model
     * @param string
     * @return collection
     */
    public function get()
    {
        return BrandModel::all();
    }

     /**
     * Get a all models
     *
     * @param int
     */
    public function getAllModels()
    {
        return BrandModel::select('uuid','model_name')->orderBy('model_name')->where('is_active', 'Y')->get();
    }

    /**
     * Get models associated with brands
     *
     * @param int
     */
    public function getActiveBrandModels($brandId)
    {
        return BrandModel::select('uuid','model_name')->where('brand_id', $brandId)->where('is_active', 'Y')->orderBy('model_name')->get();
    }

    /**
     * get a Model by it's UUID
     * @param string
     * @return collection
     */
    public function getByUuid($uuid)
    {
        return BrandModel::where('uuid',$uuid)->first();
    }

    /**
	 * Get a brand by it's slug
	 *
	 * @param int
	 */
	public function getBySlug($slug)
    {
        return BrandModel::where('slug',$slug)->first();
    }

    /**
     * Create new model.
     * @param array Model data
     */
    public function create(array $modelData)
    {
        $model = new BrandModel();
        try {
            $model->model_name = $modelData['model_name'];
            $model->brand_id = $modelData['brand_id'];
            $model->save();
            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
    /**
     * Updates existing model.
     *
     * @param Model object
     * @param array Model data
     */
    public function update(BrandModel $model, array $modelData)
    {
        try {
            $model->model_name = $modelData['model_name'];
            $model->brand_id = $modelData['brand_id'];
            $model->save();
            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

 /**
	 * Updates model status.
	 *
	 * @param int
	 * @param array
	 */
	public function status(BrandModel $model, $status){
        try {
            $model->is_active =  ($status == 'N') ? 'Y' : 'N';
            $model->save();
            return $model;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
	 * Delete a model.
	 *
	 * @param int
	 * @param array
	 */
	public function delete(BrandModel $model){
        DB::beginTransaction();
		try {
			$model->delete();
		} catch (\Exception $exception) {
			DB::rollBack();
			throw $exception;
		}
		DB::commit();
		return $model;
    }

}
