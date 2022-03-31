<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Interfaces\BrandRepositoryInterface;
use App\Http\Interfaces\BoatRepositoryInterface;
use App\Http\Interfaces\UserRepositoryInterface;
use App\Http\Interfaces\CategoryRepositoryInterface;


use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Option;
use App\Models\Category;
use App\Models\Boat;
use App\Models\BlockedBoat;
use App\Models\FavoriteBoat;
use App\Models\ExcludedBoat;

class ListingController extends Controller
{
    private $brandRepository;
    private $boatRepository;
    private $categoryRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BrandRepositoryInterface $brandRepository,
        CategoryRepositoryInterface $categoryRepository,
        UserRepositoryInterface $userRepository,
        BoatRepositoryInterface $boatRepository
        ) {
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->boatRepository = $boatRepository;
    }


    /**
     * Show the error page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function errorPage()
    {
        return view('front.listings.error-page');
    }

        /**
     * Show my yacht page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function boatInformation()
    {
        return view('front.listings.boat-information');
    }

    /**
     * Show my boats page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userBoats()
    {
        $user = Auth::user();
        return view('front.listings.user-boats', compact(['user']));
    }

    /**
     * Show the filter page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showBoatListings(Request $request) {
        $defaultConfig = config('yatchfindr.defaults');
        $brands = Brand::where('is_active','Y')->orderBy('name')->get();
        $models = BrandModel::where('is_active','Y')->orderBy('model_name')->get();
        $hullMaterials = Option::where('option_type','hull_material')->where('is_active','Y')->orderBy('name')->get();
        $categories = Category::where('is_active','Y')->orderBy('name')->get();
        $boats = Boat::select('boats.*')->unblockedBoats()->with(['boatInfo','engine', 'images'])->where('boats.is_active', 'Y')->filter($request->all())->paginate()->onEachSide(0);

        return view('front.listings.explore-boat-listing', compact('defaultConfig', 'brands', 'models', 'hullMaterials' ,'categories' , 'boats', 'request'));
    }

    /**
     * Show the about us page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function aboutUs()
    {
        return view('front.listings.about-us');
    }

    /**
     * Show the filter page in catalogue form .
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showBoatGridListings(Request $request)
    {
        $defaultConfig = config('yatchfindr.defaults');

        $brands = Brand::where('is_active','Y')->orderBy('name')->get();
        $models = BrandModel::where('is_active','Y')->orderBy('model_name')->get();
        $hullMaterials = Option::where('option_type','hull_material')->where('is_active','Y')->orderBy('name')->get();
        $categories = Category::where('is_active','Y')->orderBy('name')->get();

        $boats = Boat::select('boats.*')->unblockedBoats()->with(['boatInfo','engine', 'images'])->where('boats.is_active', 'Y')->filter($request->all())->paginate()->onEachSide(0);
        return view('front.listings.explore-boat-grid-listing',  compact('defaultConfig', 'brands', 'models', 'hullMaterials' ,'categories' , 'boats', 'request'));
    }

    /**
     *  Allow user to show  yacht information
     */
    public function showBoat($slug)
    {
        $boat = $this->boatRepository->getBySlug($slug);
        if(!empty($boat) && isset($boat)){
            $boatSuggestions = Boat::where('uuid', '!=' , $boat->uuid)
                                    ->where('brand_id', $boat->brand_id)
                                    ->orWhere('category_id', $boat->category_id)
                                    ->get();
            return view('front.listings.boat-information', compact(['boat', 'boatSuggestions']));
        }else{
            return view('errors.404');
        }
    }

    /**
     * Show the contact us page .
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contactUs()
    {
        return view('front.listings.contact-us');
    }

    /**
     * Show the about us page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function livewireListing()
    {
        return view('front.listings.livewire-listing');
    }

    /**
     * This function is use to block yacht and show the contents as per block boats
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function blockBoat(Request $request)
    {
        if(isset($request->boat_slug) && isset(Auth::user()->id)){
            $boat = $this->boatRepository->getBySlug($request->boat_slug);
            $blockBoat = new BlockedBoat();
            $blockBoat->boat_id = $boat->id;
            $blockBoat->user_id = Auth::user()->id;
            $blockBoat->save();
            $this->success('Yacht blocked successfully!')->push();
        }
        return redirect()->back();
    }

/**
     * This function is use to add favorite boat
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addToFavoriteBoat(Request $request)
    {
        if(isset($request->boat_slug) && isset(Auth::user()->id)){
            $boat = $this->boatRepository->getBySlug($request->boat_slug);
            $favoriteBoat = FavoriteBoat::firstOrCreate(
                [
                    'boat_id' => $boat->id,
                    'user_id' => Auth::user()->id,
                ],
                []
            );
            if($favoriteBoat){
                $this->success('Yacht added to favorite successfully!')->push();
            }else{
                $this->success('Failed to add yacht to favorite!')->push();
            }
        }
        return redirect()->back();
    }

    /**
     * This function is use to exclude yacht.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function excludeBoat(Request $request)
    {
        if(isset($request->boat_slug) && isset(Auth::user()->id)){
            $boat = $this->boatRepository->getBySlug($request->boat_slug);
            $excludeBoat = ExcludedBoat::firstOrCreate(
                [
                    'boat_id' => $boat->id,
                    'user_id' => Auth::user()->id,
                ],
                []
            );
            if($excludeBoat){
                $this->success('Yacht added to Exclusion successfully!')->push();
            }else{
                $this->success('Failed to add yacht to Exclusion!')->push();
            }
        }
        return redirect()->back();
    }

    /**
     * Show the brand listings page.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showBrandsListings() {
        $brandsListings = [];
        $characterListing = config('yatchfindr.defaults.ALPHABETS');
        $characterPosition = 65;
        $brandsCorrespondToCharacters = [];
        while($characterPosition <= 90){
            $brands = Brand::where('name',  'like', chr($characterPosition) .'%')->get();
            if(count($brands)>0){
                $brandsListings = [];
                foreach($brands as $brand){
                    array_push($brandsListings, ['name' => $brand->name, 'slug' => $brand->slug]);
                }
                array_push($brandsCorrespondToCharacters, ['character' => chr($characterPosition), 'list' => $brandsListings]);
            }else{
                array_push($brandsCorrespondToCharacters, ['character' => chr($characterPosition), 'list' => []]);
            }
            $characterPosition++;
        }

        return view('front.listings.brand-listing', compact('brandsCorrespondToCharacters', 'characterListing'));
    }

    /**
     * Show the brand listings page.
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showCategoriesListings() {
        $categoriesList = [];
        $categoriesList = Option::whereOptionType('boat_type')->get();
        $categoriesData = [];
        foreach($categoriesList as $categoryList){
            $categories = Category::where('boat_type', $categoryList->name)->get();
            if(count($categories) > 0){
                $categoriesListings = [];
                foreach($categories as $category){
                    array_push($categoriesListings, ['name' => $category->name, 'slug' => $category->slug]);
                }
                array_push($categoriesData, ['name' => $categoryList->name, 'uuid' =>$categoryList->uuid,  'list' => $categoriesListings]);
            }else{
                array_push($categoriesData, ['name' => $categoryList->name, 'list' => []]);
            }
        }

        return view('front.listings.category-listing', compact('categoriesData', 'categoriesList'));
    }


    /**
     *  Allow user to show  brand information
     */
    public function showBrand($slug)
    {
        $boatSuggestions =[];
        $brand = $this->brandRepository->getBySlug($slug);
        if(!empty($brand) && isset($brand)){
            $boatSuggestions = Boat::where('brand_id', $brand->id)->where('boats.is_active', 'Y')->orderBy('id', 'desc')->take(4)->get();
            return view('front.listings.brand-information', compact(['brand', 'boatSuggestions']));
        }else{
            return view('errors.404');
        }
    }

    /**
     *  Allow user to show  brand information
     */
    public function showCategory($slug)
    {
        $categorySuggestions =[];
        $category = $this->categoryRepository->getBySlug($slug);

        if(!empty($category) && isset($category)){
            $boatSuggestions = Boat::select('boats.*')
                                        ->where('category_id', $category->id)
                                        ->where('boats.is_active', 'Y')
                                        ->orderBy('id', 'desc')
                                        ->take(4)
                                        ->get();
            return view('front.listings.category-information', compact(['category', 'boatSuggestions']));
        }else{
            return view('errors.404');
        }

    }

}
