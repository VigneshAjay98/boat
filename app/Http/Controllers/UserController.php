<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Boat;
use App\Models\User;
use App\Models\BlockedBoat;
use App\Models\FavoriteBoat;

use App\Libraries\SendEmailToSellerHelper;

use App\Http\Interfaces\BasicInfoRepositoryInterface;
use App\Http\Interfaces\UserRepositoryInterface;
use App\Http\Interfaces\BoatRepositoryInterface;
use App\Http\Interfaces\PlanRepositoryInterface;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\SaveUserRequest;
use App\Models\Country;
use App\Models\State;
use App\Models\PlanAddon;
use App\Models\ExcludedBoat;
use App\Models\Order;
use DataTables;

class UserController extends Controller
{

    private $basicInfoRepository;
    private $userRepository;
    private $boatRepository;
    private $planRepository;

    public function __construct(
        BasicInfoRepositoryInterface $basicInfoRepository,
        UserRepositoryInterface $userRepository,
        BoatRepositoryInterface $boatRepository,
        PlanRepositoryInterface $planRepository
    ) {
        $this->basicInfoRepository = $basicInfoRepository;
        $this->userRepository = $userRepository;
        $this->boatRepository = $boatRepository;
        $this->planRepository = $planRepository;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $user = Auth::user();
        $countries = Country::all();
        $country = Country::where('name', $user->country)->first();
        $states = [];
        if(isset($country)){
            $states = $country->states;
        }
        return view('front.users.profile', compact(['user', 'countries', 'states']));
    }
    /**
     * Allow user to change the password.
     */
    public function security()
    {
        $user = Auth::user();
        return view('front.users.secuity', compact(['user']));
    }

    public function updateProfile(SaveUserRequest $request)
    {
        $user = $this->userRepository->getByUuid($request->uuid);
        $validator = $request->validated();
        $file = null;
        if ($request->image) {
            $folderPath = "storage/users/";
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }
            $imageParts = explode(";base64,", $request->image);
            $imageTypeAux = explode("image/", $imageParts[0]);
            $imageType = $imageTypeAux[1];
            $imageBase64 = base64_decode($imageParts[1]);
            $file = $folderPath . uniqid() . '.'.$imageType;
            // Use storage::put('file','url')
            file_put_contents($file, $imageBase64);
            if (isset($user->image) &&  File::exists($user->image)) {
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

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $validator = $request->validated();
        try {
            $user = $this->userRepository->getByUuid($validator['uuid']);
            if(Hash::check($validator['old_password'], $user->password)){
                $user = $this->userRepository->updatePassword($user, $validator);
                if(isset($user)){
                    $this->success('Password updated successfully!')->push();
                }else{
                    $this->error('Failed to update password!')->push();
                }
            }else{
                $this->error('Please enter valid password!')->push();
            }
        } catch (\Exception $exception) {
            $this->error('Failed to update password!')->push();
        }
        return redirect('/security');
    }

    /**
     *  Allow user to show personal boat information
     */
    public function verifyEmail($uuid){
        $user = $this->userRepository->getByUuid($uuid);
        if(isset($user)){
            $user = $this->userRepository->updateEmailVerifyAt($user);
            $this->success('Email verified successfully!')->push();
            Auth::login($user);
            if($user->role == 'user'){
                return redirect('/');
            }else{
                return redirect('/admin/dashboard');
            }
        }
    }

    /**
     * Show users own boats.
     */
    public function myBoats()
    {
        $user = Auth::user();
        $boats = Boat::with(['boatInfo','engine', 'images'])->orderBy('id', 'DESC')->whereUserId($user->id)->paginate()->onEachSide(-0.3);
        $addons = PlanAddon::all();

        return view('front.users.my-boats', compact(['user', 'boats', 'addons']));
    }

    /**
     * Show users blocked boats.
     */
    public function blockedBoats()
    {
        $user = Auth::user();
        $blockedBoatsIds = BlockedBoat::select('boat_id')
                                    ->where('user_id', Auth::user()->id)
                                    ->pluck('boat_id')
                                    ->toArray();
        $boats = Boat::whereIn('id', $blockedBoatsIds)->paginate()->onEachSide(-0.3);
        $addons = PlanAddon::all();

        return view('front.users.blocked-boats', compact(['user', 'boats', 'addons']));
    }


    /**
     * This function is use to unblock boat and show the contents as per unblock boats
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function unblockedBoat(Request $request)
    {
        if(isset($request->boat_slug) && isset(Auth::user()->id)){
            $boat = $this->boatRepository->getBySlug($request->boat_slug);
            $blockBoat = BlockedBoat::where('boat_id', $boat->id);
            if($blockBoat->delete()){
                $this->success('Yacht unblocked successfully!')->push();
            }else{
                $this->success('Failed to unblocked yachts!')->push();
            }
        }
        return redirect()->back();
    }


    /**
     * Show users favorite boats.
     */
    public function showAllFavoriteBoat()
    {
        $user = Auth::user();
        $blockedBoatsIds = FavoriteBoat::select('boat_id')
                                    ->where('user_id', Auth::user()->id)
                                    ->pluck('boat_id')
                                    ->toArray();
        $boats = Boat::whereIn('id', $blockedBoatsIds)->paginate()->onEachSide(-0.3);
        $addons = PlanAddon::all();

        return view('front.users.favorite-boats', compact(['user', 'boats', 'addons']));
    }

    /**
     * This function is use to delete favorite boat and show the contents as per delete favorite boats
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function removeFavoriteBoat(Request $request)
    {
        if(isset($request->boat_slug) && isset(Auth::user()->id)){
            $boat = $this->boatRepository->getBySlug($request->boat_slug);
            $favoriteBoat = FavoriteBoat::where('boat_id', $boat->id);
            if($favoriteBoat->delete()){
                $this->success('Yacht removed from favorite successfully!')->push();
            }else{
                $this->success('Failed to removed from favorite yachts!')->push();
            }
        }
        return redirect()->back();
    }

    /**
     * This function is use to delete favorite boat and show the contents as per delete favorite boats
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function unexcludeBoat(Request $request)
    {
        if(isset($request->boat_slug) && isset(Auth::user()->id)){
            $boat = $this->boatRepository->getBySlug($request->boat_slug);
            $excludedBoat = ExcludedBoat::where('boat_id', $boat->id);
            if($excludedBoat->delete()){
                $this->success('Yacht removed from exclusion successfully!')->push();
            }else{
                $this->success('Failed to removed yacht from exclusion!')->push();
            }
        }
        return redirect()->back();
    }

    /**
    * Show users orders.
    */
    public function myOrders(Request $request)
    {
        return view('front.users.my-orders');
    }

    /**
    * Show users orders.
    */
    public function myOrdersList(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            // $data = Order::where('user_id', $user->id);
            $data = Order::select('uuid', 'invoice_id', 'order_date', 'status')->where('user_id', $user->id);
            return Datatables::of($data)
                ->orderColumn('invoice_id', 'invoice_id $1')
                ->orderColumn('order_date', 'order_date $1')
                ->orderColumn('status', 'status $1')
                ->addColumn('invoice_id', function($row){
                    return '#'.$row->invoice_id;
                })
                ->addColumn('order_date', function($row){
                    return $row->order_date;
                })
                ->addColumn('status', function($row){
                    return ucfirst($row->status);
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0);" class="text-primary"><i class="fi-file"></i></a> | <a href="javascript:void(0);" data-redirect-url="" class="text-danger"><i class="fi-download"></i></a>';
                    return $actionBtn;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->search) {
                        $query->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('invoice_id', 'LIKE', "%".$search."%")
                            ->orWhere('order_date', 'LIKE', "%".$search."%")
                            ->orWhere('status', 'LIKE', "%".$search."%");
                        });
                    }
                })
                ->rawColumns(['invoice_id','order_date','status','action'])
                ->make(true);
        }
    }

    /**
     *  Allow user to show personal boat information
     */
    public function showBoat($slug)
    {
        $boat = $this->boatRepository->getBySlug($slug);
        if(!empty($boat) && isset($boat)){
            $boatSuggestions = Boat::whereBrandId($boat->brand_id)->orWhere('category_id', $boat->category_id)->get();
            return view('front.users.boat-information', compact(['boat', 'boatSuggestions']));
        } else {
            //$this->success('Requested boat dosn\'t exist!')->push();
			// return redirect()->back();
            return view('errors.404');
        }
    }

    /**
     *  Send a mail to boat seller
     */
    public function emailToBoatSeller(Request $request)
    {
        $status = 'error';
        $responseCode = 422;
        if(isset($request->message) && isset($request->email)){
            $response = SendEmailToSellerHelper::sendEmail($request->email, $request->message);
            if($response){
                $status = 'success';
                $responseCode = 200;
            }
        }
        return response()->json(['status' => $status], $responseCode);
    }
}
