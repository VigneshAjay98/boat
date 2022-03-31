<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Interfaces\UserRepositoryInterface;
use App\Http\Requests\SaveUserRequest;

use App\Models\User;
use DataTables;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function index() {
        return view('admin.users.index');
    }

    public function create() {
        return view('admin.users.user-form');
    }

    public function store(SaveUserRequest $request) {

        $validator = $request->validated();
        $file = null;
        if ($request->file('image')) {
            $md5Name = md5_file($request->file('image')->getRealPath());
            $guessExtension = $request->file('image')->guessExtension();
            $request->file('image')->storeAs('public/users', $md5Name . '.' . $guessExtension, 'local');
            $file = 'storage/users/' . $md5Name . '.' . $guessExtension;
        }

        $user = $this->userRepository->create($validator, $file);
        if ($user) {

            $this->success('User added successfully!')->push();
            return redirect('/admin/users');
        } else {
            $this->error('Failed to add User!')->push();
            return view('admin.users.user-form');
        }

    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.user-form', compact('user'));
    }

    public function update(User $user, SaveUserRequest $request)
    {

        $validator = $request->validated();
        $file = null;
        if ($request->file('image')) {
            $md5Name = md5_file($request->file('image')->getRealPath());
            $guessExtension = $request->file('image')->guessExtension();
            $request->file('image')->storeAs('public/users', $md5Name . '.' . $guessExtension, 'local');
            $file = 'storage/users/' . $md5Name . '.' . $guessExtension;
            if (isset($user->image) && File::exists($user->image)) {
                File::delete($user->image);
            }
        }
        $user = $this->userRepository->update($user, $validator, $file);
        if ($user) {

            $this->success('User updated successfully!')->push();
        } else {
            $this->error('Failed to update User!')->push();
        }

        return redirect('/admin/users');
    }

    // DATATABLES USERS

    public function usersList(Request $request) {
        if ($request->ajax()) {
            $data = User::where('role', 'user');
            return Datatables::of($data)
                ->addColumn('name', function($row){
                    return ucfirst($row->full_name);
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.url('/admin/users')."/".$row->uuid."/edit".'" class="edit text-primary"><i class="bi bi-pencil-square"></i></a> <a href="'.url('/admin/users')."/".$row->uuid.'" data-redirect-url="'.url('/admin/users').'" class="text-danger delete-confirmation"><i class="bi bi-trash-fill"></i></a>';
                    return $actionBtn;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->search) {
                        $query->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('first_name', 'LIKE', "%".$search."%")
                            ->orWhere('last_name', 'LIKE', "%".$search."%")
                            ->orWhere('email', 'LIKE', "%".$search."%")
                            ->orWhere('contact_number', 'LIKE', "%".$search."%");
                        });
                    }
                })
                ->rawColumns(['name','action'])
                ->make(true);
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return view('layouts.profile', compact('user'));
    }

    public function profileUpdate(SaveUserRequest $request)
    {
        $user = $this->userRepository->getByUuid($request->uuid);
        $validator = $request->validated();
        $file = null;
        if ($request->has('image')) {
            $md5Name = md5_file($request->file('image')->getRealPath());
            $guessExtension = $request->file('image')->guessExtension();
            $request->file('image')->storeAs('public/users', $md5Name . '.' . $guessExtension, 'local');
            $file = 'storage/users/' . $md5Name . '.' . $guessExtension;
            if (isset($user->image) && File::exists($user->image)) {
                File::delete($user->image);
            }
        } else {
            $file = $user->image;
        }
        $user = $this->userRepository->update($user, $validator, $file);
        if ($user) {

            $this->success('Profile updated successfully!')->push();
        } else {
            $this->error('Failed to update profile!')->push();
        }
        return redirect($request->redirect_url);
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $message = 'User does not found! Please try again';
        if (!empty($user)) {
            try {
                if (isset($user->image) && File::exists($user->image)) {
                    File::delete($user->image);
                }
                $user = $this->userRepository->delete($user);
                $this->success('User deleted successfully!')->push();
                return response()->json(['status' => 'success'], 200);
            } catch (\Exception $exception) {
                $this->error($message)->push();
            }
        }
        $this->error($message)->push();
        return response()->json(['status' => 'success'], 422);
    }
}
