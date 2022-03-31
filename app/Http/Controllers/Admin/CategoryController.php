<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Interfaces\CategoryRepositoryInterface;
use App\Http\Interfaces\OptionRepositoryInterface;
use App\Http\Requests\SaveCategoryRequest;

use App\Models\Category;
use DataTables;

class CategoryController extends Controller
{
    private $categoryRepository;
    private $optionRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        OptionRepositoryInterface $optionRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->optionRepository = $optionRepository;
    }

    public function index() {
        return view('admin.categories.index');
    }

    public function create() {
        $boat_types = $this->optionRepository->getActiveBoatTypes();
        $activities = $this->optionRepository->getActiveActivities();

        return view('admin.categories.category-form', compact('boat_types', 'activities'));
    }

    public function store(SaveCategoryRequest $request) {

        $validator = $request->validated();

        $category = $this->categoryRepository->create($validator);
        if ($category) {
            $this->success('Category added successfully!')->push();
            return redirect('/admin/categories');
        } else {
            $this->error('Failed to add Category!')->push();
            return redirect()->back();
        }

    }

    public function edit(Category $category)
    {
        $boat_types = $this->optionRepository->getActiveBoatTypes();
        $activities = $this->optionRepository->getActiveActivities();

        return view('admin.categories.category-form', compact('category', 'boat_types', 'activities'));
    }

    public function update(Category $category, SaveCategoryRequest $request)
    {
        $validator = $request->validated();
        $category = $this->categoryRepository->update($category, $validator);
        if ($category) {
            $this->success('Category updated successfully!')->push();
            return redirect('/admin/categories');
        } else {
            $this->error('Failed to update Category!')->push();
            return redirect()->back();
        }
    }

    // Get all categories for Datatable Listing
    public function categoriesList(Request $request) {
        if ($request->ajax()) {
            $data = Category::get();
            return Datatables::of($data)
                ->addColumn('name', function($row){
                    return ucfirst($row->name);
                })
                ->addColumn('type', function($row){
                    return ucfirst($row->boat_type);
                })
                ->addColumn('is_active', function($row){
                    $is_active = $row->is_active == 'N' ? '' : 'checked';
                    return '<div class="form-check form-switch">
                              <input class="form-check-input categoryStatus" data-url="'.url('').'" data-uuid="'.$row->uuid.'" type="checkbox" '.$is_active.'>
                            </div>';
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.url('')."/admin/categories/".$row->uuid."/edit".'" class="text-primary" data-title="Edit Category"><i class="bi bi-pencil-square"></i></a> <a href="'.url('')."/admin/categories/".$row->uuid.'" data-redirect-url="'.url('')."/admin/categories".'" class="text-danger delete-confirmation"><i class="bi bi-trash-fill"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['name','type','is_active','action'])
                ->make(true);
        }
    }

    /*Change status from categories listing*/
    public function status($uuid)
    {
        $category = $this->categoryRepository->getByUuid($uuid);
        if ($category) {
            if(count($category->boats) > 0 && $category->is_active == 'Y'){
                $status = 'prohibited';
                $message = 'Status can not be changed, Category is already assigned to boats!';
                $code = 422;
            } else {
                $result = $this->categoryRepository->changeStatus($category);
                if ($result) {
                    $status = 'success';
                    $message = 'Category status updated successfully!';
                    $code = 200;
                }
            }
            return response()->json([
                'status' => $status,
                'message' => $message
            ], $code);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Category does not found! Please try again later'
            ], 422);
        }
    }

    /**
     * Remove the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (!empty($category)) {
            if(count($category->boats) > 0 && $category->is_active == 'Y'){
                $this->error('Cannot delete this category, Category is associated with boats!')->push();
                $status = 'prohibited';
                $code = 422;
            } else {
                $category = $this->categoryRepository->delete($category);
                $this->success('Category deleted successfully!')->push();
                $status = 'success';
                $code = 200;
            }
            return response()->json([
                'status' => $status,
            ], $code);
        }else {
            $this->error('Category does not found! Please try again')->push();
            return response()->json(['status' => 'error'], 404);
        }
    }

}
