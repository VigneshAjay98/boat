<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Interfaces\BoatRepositoryInterface;
use App\Http\Interfaces\BrandRepositoryInterface;
use App\Http\Interfaces\ModelRepositoryInterface;
use App\Http\Interfaces\OptionRepositoryInterface;
use App\Http\Interfaces\CategoryRepositoryInterface;
use App\Http\Interfaces\BasicInfoRepositoryInterface;
use App\Http\Interfaces\SecondDetailsRepositoryInterface;
use App\Http\Interfaces\DetailsRepositoryInterface;
use App\Http\Interfaces\BoatLocationRepositoryInterface;
use App\Http\Interfaces\PlanRepositoryInterface;

use App\Http\Requests\SaveBasicInfoRequest;
use App\Http\Requests\SaveDetailsRequest;
use App\Http\Requests\SaveSecondDetailsRequest;
use App\Http\Requests\SaveLocationInfoRequest;

use App\Models\Boat;
use App\Models\Coupon;
use App\Models\OtherInformation;
use App\Models\Engine;
use App\Models\BoatImage;
use App\Models\BoatVideo;

use Auth;
use Session;

class BoatController extends Controller
{
    private $boatRepository;
    private $brandRepository;
    private $modelRepository;
    private $optionRepository;
    private $categoryRepository;
    private $basicInfoRepository;
    private $detailsRepository;
    private $secondDetailsRepository;
    private $locationRepository;
    private $planRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BoatRepositoryInterface $boatRepository,
        BrandRepositoryInterface $brandRepository,
        ModelRepositoryInterface $modelRepository,
        OptionRepositoryInterface $optionRepository,
        CategoryRepositoryInterface $categoryRepository,
        BasicInfoRepositoryInterface $basicInfoRepository,
        SecondDetailsRepositoryInterface $secondDetailsRepository,
        BoatLocationRepositoryInterface $locationRepository,
        DetailsRepositoryInterface $detailsRepository,
        PlanRepositoryInterface $planRepository
    ) {
        $this->boatRepository = $boatRepository;
        $this->brandRepository = $brandRepository;
        $this->modelRepository = $modelRepository;
        $this->optionRepository = $optionRepository;
        $this->categoryRepository = $categoryRepository;
        $this->basicInfoRepository = $basicInfoRepository;
        $this->secondDetailsRepository = $secondDetailsRepository;
        $this->locationRepository = $locationRepository;
        $this->detailsRepository = $detailsRepository;
        $this->planRepository = $planRepository;
    }

    /**
     * Show the Sell Your boat page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     $brands = $this->brandRepository->getActiveBrands();
    //     $boat_types = $this->optionRepository->getActiveBoatTypes();
    //     $hull_materials = $this->optionRepository->getHullMaterials();
    //     $models = $this->modelRepository->getAllModels();
    //     return view('front.listings.step1', compact('brands', 'boat_types', 'hull_materials', 'models'));
    // }


    public function stepOne(Request $request) {

        $brands = $this->brandRepository->getActiveBrands();
        // $boat_types = $this->optionRepository->getActiveBoatTypes();
        if($request->boat_uuid) {
            $basicInfo = $this->basicInfoRepository->getByBoatUuid($request->boat_uuid);
        }else {
            $basicInfo = $this->basicInfoRepository->getByUserId();
        }

        $firstCategories = $this->categoryRepository->getFirstTypeCategories();
        $plan = false;
        if(!empty($basicInfo)) {
            $plan = $this->planRepository->getPlan($basicInfo->id);
        }

        $selectedCategories = '';
        if(!empty($basicInfo->boat_type)) {
        //     $option = $this->optionRepository->getBoatTypeOption($basicInfo->boat_type);
            $selectedCategories = $this->categoryRepository->getBoatTypeCategories($basicInfo->boat_type);
        }
       

        if($plan || (!empty($basicInfo) && $basicInfo->payment_status == 'paid')) {
            return view('front.listings.step-one', compact('brands', 'firstCategories', 'selectedCategories', 'basicInfo'));
        } else {
           return redirect()->route('select-plan');
        }
    }

    public function storeStepOne(SaveBasicInfoRequest $request) {

        $validator = $request->validated();

        $basicInfo = $this->basicInfoRepository->store($validator);

        if(isset($request['next'])){

            if($basicInfo) {
                return redirect()->route('step-two', ['boat_uuid' => $validator['boat_uuid'] ]);
            }
            else {
                return redirect()->route('step-one', ['boat_uuid' => $validator['boat_uuid'] ]);
            }
        } else {
            return redirect()->route('my-yachts');
        }
    }

    public function stepTwo(Request $request) {

        $hull_materials = $this->optionRepository->getHullMaterials();


        if(!empty($request->boat_uuid)) {
            $details = $this->basicInfoRepository->getByBoatUuid($request->boat_uuid);
        }else {
            $details = $this->basicInfoRepository->getByUserId();
        }

        $checkModelExists =  $this->detailsRepository->getModel();
        if(!empty($details) && ($checkModelExists || $details->payment_status=='paid')) {
            return view('front.listings.step-two', compact('hull_materials', 'details'));
        }
        else {
            return redirect()->route('step-one', ['boat_uuid' => $request->boat_uuid ]);
        }

    }

     public function storeStepTwo(SaveDetailsRequest $request) {

       
        $filter = array_slice($request->all(), 1);

        $splitIndex = array_search('hull_material', array_keys($filter));
        $engines = array_chunk(array_splice($filter, 0, $splitIndex), 6);
        $otherInfo = $filter;

        $this->detailsRepository->storeEngine($engines, $otherInfo['boat_uuid']);

        $checkOtherInfo = $this->detailsRepository->storeOtherInformation($otherInfo, $otherInfo['boat_uuid']);
        if(isset($request['next'])){
            if($checkOtherInfo) {
                return redirect()->route('step-three', ['boat_uuid' => $otherInfo['boat_uuid'] ]);
            }else {
                return redirect()->route('step-two', ['boat_uuid' => $otherInfo['boat_uuid'] ]);
            }
        } else {
            return redirect()->route('my-yachts');
        }
    }

    public function stepThree(Request $request) {

        $countries = $this->secondDetailsRepository->getAllCountries();
        if(!empty($request->boat_uuid)) {
            $secondDetails = $this->basicInfoRepository->getByBoatUuid($request->boat_uuid);
        }else {
            $secondDetails = $this->basicInfoRepository->getByUserId();
        }

        $checkEngineExists = $this->secondDetailsRepository->getEngine();

        if(!empty($secondDetails) && ($checkEngineExists || $secondDetails->payment_status=='paid')) {
            return view('front.listings.step-three', compact('secondDetails'));
        }else {
            return redirect()->route('step-two', ['boat_uuid' => $request->boat_uuid ]);
        }

    }

    public function storeStepThree(SaveSecondDetailsRequest $request) {

        $validator = $request->validated();
        $secondDetails = $this->secondDetailsRepository->store($validator);
        if(isset($request['next'])){
            if($secondDetails) {
                return redirect()->route('step-four', ['boat_uuid' => $validator['boat_uuid'] ]);
            }
            else {
                return redirect()->route('step-two', ['boat_uuid' => $validator['boat_uuid'] ]);
            }
        } else {
            return redirect()->route('my-yachts');
        }
    }

    public function stepFour(Request $request) {

        $countries = $this->locationRepository->getAllCountries();
        if(!empty($request->boat_uuid)) {
            $locationInfo = $this->basicInfoRepository->getByBoatUuid($request->boat_uuid);
        }else {
            $locationInfo = $this->basicInfoRepository->getByUserId();
        }

        $states = '';
        if(!empty($locationInfo->country)) {
            $states = $this->locationRepository->getByCountry($locationInfo->country);
        }
        else{
            $states = $this->locationRepository->getByCountry("United States");
        }

        $checkDescriptionExists = $this->locationRepository->getDescription();

        if(!empty($locationInfo) && ($checkDescriptionExists || $locationInfo->payment_status=='paid')) {
            return view('front.listings.step-four', compact('countries', 'locationInfo', 'states'));
        }else {
            return redirect()->route('step-three', ['boat_uuid' => $request->boat_uuid ]);
        }

    }

    public function storeStepFour(SaveLocationInfoRequest $request) {

        $validator = $request->validated();

        if ($request->boat_images) {
            $this->locationRepository->storeImages($request->boat_images, $validator['boat_uuid']);
        }

        if ($request->boat_videos) {
            $this->locationRepository->storeVideos($request->boat_videos, $validator['boat_uuid']);
        }

        $locationInfo = $this->locationRepository->store($validator);

        if(isset($request['next'])){
            if(!empty($validator['boat_uuid'])) {
                $this->success('Yacht Updated Successfully!')->push();
                return redirect()->route('my-yachts');
            }else {
                if($locationInfo) {
                    return redirect()->route('step-five');
                }
                else {
                    return redirect()->route('step-four', ['boat_uuid' => $validator['boat_uuid'] ]);
                }
            }
        } else {
            return redirect()->route('my-yachts');
        }
    }

    public function stepFive() {
        
        $user = Auth::user();
        $intent = $user->createSetupIntent();
        $coupon = '';

        $plan = $this->locationRepository->getPackageByUserId();

        $boat = Boat::where('user_id', Auth()->user()->id)
                    ->where('payment_status', 'unpaid')
                    ->where('publish_status', 'draft')
                    ->where('is_active', 'N')
                    ->latest()->first();

        $countries = $this->locationRepository->getAllCountries();
        $states = $this->locationRepository->getByCountry("United States");

        if(isset($boat->userPlanAddons) && (count($boat->userPlanAddons) > 0) ) {
            $userAddons = $boat->userPlanAddons;
            $couponMatch = Coupon::where('id', $userAddons[0]->coupon_id)->first();
            if($couponMatch) {
                $coupon = $couponMatch;
            }
        }

        if($plan) {
            if(!empty($plan)) {
                $addons = $this->planRepository->getPackageAddOns($boat->id, $plan->id);
                if(!empty($addons)) {
                    return view('front.listings.step-five', compact('plan', 'addons', 'countries', 'states', 'coupon', 'intent', 'user','boat'));
                }else {
                    return redirect()->route('step-four');
                }
            }
        }else {
            return redirect()->back();
        }

    }

    /**
     * get categories for selected boat type AJAX.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getTypeCategories(Request $request, $boatType) {
        // $boat_type = $this->optionRepository->getByUuid($uuid);
        if($boatType) {
            $getCategories = $this->categoryRepository->getBoatTypeCategories($boatType);
            return response()->json([
                'status' => 'success',
                'categories' => $getCategories
            ], 200);
        }else {
            return response()->json([
                'status' => 'error',
            ], 422);
        }
    }

     /**
     * get models for selected brands AJAX.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBrandModels(Request $request, $uuid) {
        $brand = $this->brandRepository->getByUuid($uuid);
        if($brand) {
            $getModels = $this->modelRepository->getActiveBrandModels($brand->id);
            return response()->json([
                'status' => 'success',
                'models' => $getModels
            ], 200);
        }else {
            return response()->json([
                'status' => 'error',
            ], 422);
        }
    }

    /**
     * get states for selected Country AJAX.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getStates(Request $request, $country) {
        $states = $this->secondDetailsRepository->getByCountry($country);
        if($states) {
            return response()->json([
                'status' => 'success',
                'states' => $states
            ], 200);
        }else {
            return response()->json([
                'status' => 'error',
            ], 422);
        }
    }

    /**
     * get images for boat.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBoatImages(Request $request, $boatUuid) {

        $boat = $this->basicInfoRepository->getByBoatUuid($boatUuid);

        if(count($boat->images) > 0) {
            $images = [];
            foreach($boat->images as $image) {
                array_push($images, $image->image_name);
            }
            return response()->json([
                'status' => 'success',
                'images' => $images,
                'imagesNum' => $boat->plan->image_number
            ], 200);
        }else {
            return response()->json([
                'status' => 'error',
            ], 422);
        }

    }

    /**
     * get images for boat.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getBoatVideos(Request $request, $boatUuid) {

        $boat = $this->basicInfoRepository->getByBoatUuid($boatUuid);

        if(count($boat->videos) > 0) {
            $videos = [];
            foreach($boat->videos as $video) {
                array_push($videos, $video->video_name);
            }
            return response()->json([
                'status' => 'success',
                'videos' => $videos,
                'videosNum' => $boat->plan->video_number
            ], 200);
        }else {
            return response()->json([
                'status' => 'error',
            ], 422);
        }

    }

    /**
     * Remove yacht from my-yachts.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function deleteYacht(Request $request, $boatUuid) {

        $boat = Boat::where('uuid', $boatUuid)->first();

        if($boat) {
            try {

                $otherInformation = OtherInformation::where('boat_id', $boat->id)->first();
                $engines = Engine::where('boat_id', $boat->id)->get();
                $images = BoatImage::where('boat_id', $boat->id)->get();
                $videos = BoatVideo::where('boat_id', $boat->id)->get();

                if($otherInformation) {
                    $otherInformation->delete();
                }

                if(count($engines) > 0) {
                    foreach($engines as $engine) {
                        $engine->delete();
                    }
                }

                if(count($images) > 0) {
                    foreach($images as $image) {
                        $image->delete();
                    }

                    $folderPath = 'storage/boats/images/'.$boat->uuid.'/';
                    if (file_exists($folderPath)) {
                        \File::deleteDirectory($folderPath);
                    }
                }

                if(count($videos) > 0) {
                    foreach($videos as $video) {
                        $video->delete();
                    }

                    $folderPath = 'storage/boats/videos/'.$boat->uuid.'/';
                    if (file_exists($folderPath)) {
                        \File::deleteDirectory($folderPath);
                    }
                }

                $boat->delete();

                return response()->json([
                    'success' => true
                ], 200);

            } catch(\Exception $e) {
                # Display error on client
                return response()->json([
                        'error' => true
                ], 422);
            }

        }else {
            return response()->json([
                'error' => true,
            ], 422);
        }

    }

}
