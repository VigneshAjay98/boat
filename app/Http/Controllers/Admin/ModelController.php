<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use DataTables;

use App\Http\Interfaces\ModelRepositoryInterface;
use App\Http\Interfaces\BrandRepositoryInterface;
use App\Http\Interfaces\BoatRepositoryInterface;
use App\Http\Requests\SaveModelRequest;

use App\Models\BrandModel;

class ModelController extends Controller
{

	private $modelRepository;
	private $brandRepository;
	private $boatRepository;

	public function __construct(
		ModelRepositoryInterface $modelRepository,
		BrandRepositoryInterface $brandRepository,
		BoatRepositoryInterface $boatRepository
		) {
			$this->modelRepository = $modelRepository;
			$this->brandRepository = $brandRepository;
			$this->boatRepository = $boatRepository;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.models.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$brands = $this->brandRepository->getActiveBrands();
		return view('admin.models.models-form', compact('brands'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(SaveModelRequest $request)
	{
		$validator = $request->validated();
		$validator['brand_id'] = $this->brandRepository->getBySlug($validator['brand_slug'])->id;
		$model = $this->modelRepository->create($validator);
		if ($model) {
			$this->success('Model added successfully!')->push();
			return redirect('/admin/models');
		} else {
			$this->error('Failed to add model!')->push();
			return view('admin.models.model-form');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit(BrandModel $model)
	{
		$brands = $this->brandRepository->getActiveBrands();
		return view('admin.models.models-form', compact('brands', 'model'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(SaveModelRequest $request, BrandModel $model)
	{

		$validator = $request->validated();
		$brand = $this->brandRepository->getBySlug($validator['brand_slug']);
		$validator['brand_id'] = $brand->id;
		$model = $this->modelRepository->update($model, $validator);
		if ($model) {
			$this->success('Model added successfully!')->push();
			//return redirect('/admin/models');
		} else {
			$this->error('Failed to add model!')->push();
			//return view('admin.models.model-form');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(BrandModel $model)
	{

		$statusType = 'error';
		$status = 422;
		if (!empty($model)) {
			try {
				$brandId = $model->brand_id;
				$modelName = $model->model_name;
				$boats = $this->boatRepository->getByModelAndBrandId($modelName, $brandId);
				if((count($boats)>0)){
					$statusType = 'error';
					$status = 422;
					$this->error('Cannot delete this model, model is associated to boats!')->push();
				} else {
					$model = $this->modelRepository->delete($model);
					if ($model) {
						$this->success('Brand deleted successfully!')->push();
						$statusType = 'success';
						$status = 200;
					}
				}
			} catch (\Exception $exception) {
				$statusType = $exception->getMessage();
				$this->error('Brand does not found! Please try again')->push();
			}
		}
		return response()->json(['status' => $statusType], $status);
	}


	 /**
	 * This function provide models listings for data table
	 *
	 * @param  int  $request
	 * @return \Illuminate\Http\Response
	 */

	public function modelsList(Request $request) {
		if ($request->ajax()) {
			$models = BrandModel::all();
			return Datatables::of($models)
				->addIndexColumn()
				->addColumn('brand_name', function($model){
					return $model->brand->name;
				})
				->addColumn('status', function($model){
					$status =  $model->is_active == 'Y' ? 'checked' : '';
					return (
						'<div class="form-check form-switch">
							<input class="form-check-input model-status" type="checkbox" data-uuid='.$model->uuid.' data-status='.$model->is_active.'  '.$status.'>
						</div>');
				})
				->addColumn('action', function($model){
					$actionBtn = '<a href="javascript:void(0)" data-href="'.url('')."/admin/models/".$model->uuid."/edit".'" class="edit text-primary open-model-btn" data-title="Edit Model" data-bs-toggle="modal" data-bs-target="#boatModalBox"><i class="bi bi-pencil-square"></i></a> <a href="'.url('admin/models').'/'.$model->uuid.'" class="delete text-danger delete-confirmation" data-redirect-url="'.url('/admin/models').'"><i class="bi bi-trash-fill"></i></a>';
					return $actionBtn;
				})
				->rawColumns(['brand_name', 'status','action'])
				->make(true);
		}
	}

	/**
	 * This function update specific models status
	 *
	 * @param  int  $request
	 * @return \Illuminate\Http\Response
	 */
	public function modelsStatus($uuid, $status) {
		$model =  $this->modelRepository->getByUuid($uuid);
		$modelStatus =  $this->modelRepository->status($model, $status);
		if($modelStatus) {
			$status = 'error';
			$message = 'Something went wrong, please try again!';
			if($model) {
				$status = 'success';
				$message = 'Status updated successfully';
			}
			return response()->json([
				'model' => $model,
				'status' => $status,
				'message' => $message
			], 200);
		}
	}
}
