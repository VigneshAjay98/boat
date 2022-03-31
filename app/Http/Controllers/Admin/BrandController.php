<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use DataTables;

use App\Http\Interfaces\BrandRepositoryInterface;
use App\Http\Requests\SaveBrandRequest;

use App\Models\Brand;


class BrandController extends Controller
{
	private $brandRepository;

	public function __construct(BrandRepositoryInterface $brandRepository) {
		$this->brandRepository = $brandRepository;
	}

	/**
	 * Display a listing of brands.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.brands.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.brands.brand-form');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(SaveBrandRequest $request)
	{
		$validator = $request->validated();
		$brand = $this->brandRepository->create($validator);
		if ($brand) {
			$this->success('Brand added successfully!')->push();
			return redirect('/admin/brands');
		} else {
			$this->error('Failed to add Brand!')->push();
			return view('admin.brands.brand-form');
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
	public function edit(Brand $brand)
	{
		return view('admin.brands.brand-form', compact('brand'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(SaveBrandRequest $request, Brand $brand)
	{
		$validator = $request->validated();
		$brand = $this->brandRepository->update($brand, $validator);
		if ($brand) {
			$this->success('Brand updated successfully!')->push();
		} else {
			$this->error('Failed to update Brand!')->push();
		}

		return redirect('/admin/brands');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Brand $brand)
	{
		$statusType = 'error';
		$status = 422;
		if (!empty($brand)) {
			try {
				if((count($brand->models) > 0) || (count($brand->boats) > 0)){
					$statusType = 'error';
					$status = 422;
					$this->error('Cannot delete this brand, brand is associated to a models and boats!')->push();
				} else {
					$brand = $this->brandRepository->delete($brand);
					if ($brand) {
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
	 * This function provide brands listings for data table
	 *
	 * @param  int  $request
	 * @return \Illuminate\Http\Response
	 */

	 public function brandsList(Request $request) {
		if ($request->ajax()) {
			$brands = Brand::all();
			return Datatables::of($brands)
				->addIndexColumn()
				->addColumn('status', function($brand){
					$status =  $brand->is_active == 'Y' ? 'checked' : '';
					return (
						'<div class="form-check form-switch">
							<input class="form-check-input brand-status" type="checkbox" data-uuid='.$brand->uuid.' data-status='.$brand->is_active.'  '.$status.'>
						</div>');
				})
				->addColumn('action', function($brand){
					$actionBtn = '<a href="javascript:void(0)" data-href="'.url('')."/admin/brands/".$brand->uuid."/edit".'" class="edit text-primary open-model-btn" data-title="Edit Brand" data-bs-toggle="modal" data-bs-target="#boatModalBox"><i class="bi bi-pencil-square"></i></a> <a href="'.url('/admin/brands').'/'.$brand->uuid.'" class="delete  text-danger delete-confirmation" data-redirect-url="'.url('/admin/brands').'"><i class="bi bi-trash-fill"></i></a>';
					return $actionBtn;
				})
				->rawColumns(['status', 'action'])
				->make(true);
		}
	}

	/**
	 * This function update specific brands status
	 *
	 * @param  int  $request
	 * @return \Illuminate\Http\Response
	 */
	public function brandsStatus($uuid, $brandStatus) {
		$brand =  $this->brandRepository->getByUuid($uuid);
		if(isset($brand)){
			if(count($brand->models) > 0 && $brandStatus == 'Y'){
				$status = 'prohibited';
				$message = 'Status can not be change because brand is already assigned to models!';
			} else {
				$brandStatusResult =  $this->brandRepository->status($brand, $brandStatus);
				if($brandStatusResult) {
                    $status = 'success';
                    $message = 'Status updated successfully';
				}
			}
			return response()->json([
				'brand' => $brand,
				'status' => $status,
				'message' => $message
			], 200);
		}else{
            return response()->json([], 422);
        }
	}
}
