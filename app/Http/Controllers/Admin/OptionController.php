<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Interfaces\OptionRepositoryInterface;
use App\Http\Requests\SaveOptionRequest;

use App\Models\Option;
use DataTables;

class OptionController extends Controller
{
    private $optionRepository;

    public function __construct(OptionRepositoryInterface $optionRepository) {
        $this->optionRepository = $optionRepository;
    }

    public function index() {
        return view('admin.options.index');
    }

    public function create() {
        return view('admin.options.option-form');
    }

    public function store(SaveOptionRequest $request) {

        $validator = $request->validated();

        $option = $this->optionRepository->create($validator);
        if ($option) {
            $this->success('Option added successfully!')->push();
            return response()->json(['status' => 'success'], 200);
        } else {
            $this->error('Failed to add option!')->push();
            return response()->json(['status' => 'error'], 422);
        }

    }

    public function update(Option $option, SaveOptionRequest $request)
    {
        $validator = $request->validated();
        $option = $this->optionRepository->update($option, $validator);
        if ($option) {
            $this->success('Option updated successfully!')->push();
            return response()->json(['status' => 'success'], 200);
        } else {
            $this->error('Failed to update Option!')->push();
            return response()->json(['status' => 'error'], 422);
        }
    }

    public function edit(Option $option)
    {
        return view('admin.options.option-form', compact('option'));
    }

    // Get all options for Datatable Listing
    public function optionsList(Request $request) {

        $data = Option::select('uuid', 'name', 'option_type', 'is_active')->where('option_type', '!=', 'boat_type');

        return Datatables::of($data)
            ->orderColumn('name', 'name $1')
            ->orderColumn('option_type', 'option_type $1')
            ->addColumn('name', function($row){
                    return ucfirst($row->name);
            })
            ->addColumn('option_type', function($row){
                    return ( ($row->option_type=="boat_type") ? 'Boat Type': ( ($row->option_type=="hull_material") ? 'Hull Material' : ( ($row->option_type=="boat_activity") ? 'Boat Activity' : '--')));
            })
            ->addColumn('is_active', function($row){
                    $is_active = $row->is_active == 'N' ? '' : 'checked';
                    return '<div class="form-check form-switch">
                              <input class="form-check-input optionStatus" data-url="'.url('').'" data-uuid="'.$row->uuid.'" type="checkbox" '.$is_active.'>
                            </div>';
            })
            ->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0)" class="text-primary open-model-btn" data-href="'.url('/admin/options')."/".$row->uuid."/edit".'" data-title="Edit Option" data-bs-toggle="modal" data-bs-target="#boatModalBox"><i class="bi bi-pencil-square"></i></a> <a href="'.url('/admin/options')."/".$row->uuid.'" data-redirect-url="'.url('/admin/options').'" class="text-danger delete-confirmation"><i class="bi bi-trash-fill"></i></a>';

                return $actionBtn;
            })
            ->filter(function ($query) use ($request) {
                if ($request->option_type) {
                    $query->where('option_type', $request->option_type);
                }
                if ($request->search) {
                    $query->where(function($w) use($request){
                                $search = $request->get('search');
                                $w->orWhere('name', 'LIKE', "%".$search."%")
                                ->orWhere('option_type', 'LIKE', "%".$search."%");
                            });
                }
            })
            ->rawColumns(['name','option_type','is_active', 'action'])
            ->make(true);
    }

    /*Change status from options listing*/
    public function status($uuid)
    {
        $option = $this->optionRepository->getByUuid($uuid);
        if ($option) {
            if((count($option->categories) > 0 || count($option->activities) > 0) && $option->is_active == 'Y'){
                $status = 'prohibited';
                $message = 'Status can not be changed, Option is already assigned to categories!';
                $code = 422;
            } else {
                $result = $this->optionRepository->changeStatus($option);
                if ($result) {
                    $status = 'success';
                    $message = 'Option status updated successfully!';
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
                'message' => 'Option does not found! Please try again later'
            ], 422);
        }
    }

     /**
     * Remove the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Option $option)
    {
        if (!empty($option)) {
            if((count($option->categories)>0) || (count($option->activities)>0) ){
                $this->error('Cannot delete this option, Option is associated with categories!')->push();
                $status = 'prohibited';
                $code = 422;
            } else {
                $option = $this->optionRepository->delete($option);
                if ($option) {
                    $this->success('Option deleted successfully!')->push();
                    $status = 'success';
                    $code = 200;
                }
            }
            return response()->json([
                'status' => $status,
            ], $code);
        }else{
            $this->error('Option does not found! Please try again')->push();
            return response()->json(['status' => 'error'], 404);
        }

    }

}


