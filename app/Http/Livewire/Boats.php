<?php

namespace App\Http\Livewire;
use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use App\Paginator\ColectionPaginate;

use App\Models\Boat;
use App\Models\Brand;
use App\Models\BlockedBoat;
use App\Models\FavoriteBoat;
use App\Models\ExcludedBoat;
use App\Models\BrandModel;
use App\Models\Category;
use App\Models\Option;

use Livewire\WithPagination;

class Boats extends Component
{
    public $updateMode = false;
    // public $all_results = '';
    // public $my_favorites = '';
    // public $my_exclusions = '';
    public $showMe = '';
    public $personal_watercraft = '';
    public $power = '';
    public $sail = '';
    public $selectedBrand = '';
    public $selectedModel = '';
    public $selectedCategory = '';
    public $priceFrom = '';
    public $priceTo = '';
    public $lengthFrom = '';
    public $lengthTo = '';
    public $selectedFromYear = '';
    public $selectedToYear = '';
    public $sort = 'boats.created_at-desc';
    public $selectedBoatCondition = '';
    public $engineCount = '';
    public $selectedEngineType = '';
    public $selectedEngineFuel = '';
    public $selectedHullMaterial = '';
    public $beam = '';
    public $draft = '';
    public $bridgeClearance = '';
    public $LOA = '';
    public $selectedHead = '';
    public $selectedGenerator = '';
    public $selectedCabin = '';
    public $selectedGalley = '';
    // public $showBlockedBoats = '';
    public $viewType = 'list';
    public $models;
    public $categories = '';
    public $categoryCondition = [];

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $perPage = 10;

    public function mount(){
        $models = BrandModel::where('is_active','Y');
        $this->models = $models->orderBy('model_name')->get();

        // $this->categories = Category::where('is_active', 'Y');
    }

    public function updatedSelectedBrand(){
        $models = BrandModel::where('is_active','Y');
        if (!empty($this->selectedBrand)) {
            $models = $models->where('brand_id', $this->selectedBrand);
        }
        $this->models = $models->orderBy('model_name')->get();
    }


    public function addToFavorites($boatId) {
        $favoriteBoat = FavoriteBoat::firstOrCreate(
            [
                'boat_id' => $boatId,
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

    public function render()
    {

        // if(!empty($this->my_favorites)) {
        //     print_r($this->my_favorites); exit;
        // }

        $dispatchData = [];
        $sortOrder = explode("-", $this->sort);
        $boats = Boat::selectRaw('distinct boats.id, boats.*')
                        ->join('other_information', 'other_information.boat_id', '=', 'boats.id')
                        ->join('engines', 'engines.boat_id', '=', 'boats.id')
                        ->orderBy($sortOrder[0], $sortOrder[1]);

        // $categories = $this->categories;
        if(Auth()->check()) {
            if(!empty($this->showMe)) {

                if($this->showMe == 'my_favorites') {
                    $favoriteBoatsIds = FavoriteBoat::select('boat_id')
                                    ->where('user_id', Auth::user()->id)
                                    ->pluck('boat_id')
                                    ->toArray();
                    $boats = $boats->whereIn('boats.id', $favoriteBoatsIds);
                }

                if($this->showMe == 'my_exclusions') {
                    $excludedBoatsIds = ExcludedBoat::select('boat_id')
                                    ->where('user_id', Auth::user()->id)
                                    ->pluck('boat_id')
                                    ->toArray();
                    $boats = $boats->whereIn('boats.id', $excludedBoatsIds);
                }
                
            }
        }

        // if(!empty($this->all_results)) {
        //     $boats = $boats->whereNotIn('boats.id', $excludedBoatsIds);
        // }

        // if(!empty($this->my_exclusions)) {
        //     $boats = $boats->whereIn('boats.id', $excludedBoatsIds);
        // }

        // if(!empty(Auth::user())){
        //     $blockedBoatsIds = BlockedBoat::select('boat_id')
        //                             ->where('user_id', Auth::user()->id)
        //                             ->pluck('boat_id')
        //                             ->toArray();
        // }
        // if (!empty($this->showBlockedBoats)) {
        //     $boats = $boats->whereIn('boats.id', $blockedBoatsIds);
        // }else{
        //     if(!empty(Auth::user())){
        //         $boats = $boats->whereNotIn('boats.id', $blockedBoatsIds);
        //     }
        // }
        // print_r($this->personal_watercraft); 

        // if(!empty($this->personal_watercraft) || !empty($this->power) || !empty($this->sail) ) {
        //     $this->categories = Category::where('is_active', 'Y');
        //     $categories = $this->categories;
        // }

        if(!empty($this->personal_watercraft)) {
            $this->categoryCondition[] = $this->personal_watercraft;
            // $categories = $categories->where('boat_type', $this->personal_watercraft);
            $boats = $boats->where('boats.boat_type', $this->personal_watercraft);
        }

        if(!empty($this->power)) {
            $this->categoryCondition[] = $this->power;
            // $categories = $categories->where('boat_type', $this->power);
            $boats = $boats->where('boats.boat_type', $this->power);
        }

        if(!empty($this->sail)) {
            $this->categoryCondition[] = $this->sail;
            // $categories = $categories->where('boat_type', $this->sail);
            $boats = $boats->where('boats.boat_type', $this->sail);
        }

        // if(!empty($this->personal_watercraft) || !empty($this->power) || !empty($this->sail) ) {
        //     // print_r($this->categoryCondition);
        //     $this->categories = $categories->whereIn('boat_type', $this->categoryCondition);
        //     $this->categoryCondition= [];
        // }
        // $this->categoryCondition= [];
        // if(!empty($this->categoryCondition)) {
        //     $this->categories = $this->categories->whereIn('boat_type', $this->categoryCondition);
        // }
        // $this->categories = $this->categories->orderBy('name')->get();

        if (!empty($this->selectedFromYear) && !empty($this->selectedToYear)) {
            $boats = $boats->whereBetween('boats.year', [$this->selectedFromYear, $this->selectedToYear]);
        } else {
            if (!empty($this->selectedFromYear)) {
                $boats = $boats->where('boats.year', '>=', $this->selectedFromYear);
            }
            if (!empty($this->selectedToYear)) {
                $boats = $boats->where('boats.year', '<=', $this->selectedToYear);
            }
        }

        if (!empty($this->priceFrom) && !empty($this->priceTo)) {
            $boats = $boats->whereBetween('boats.price', [$this->priceFrom, $this->priceTo]);
        } else {
            if (!empty($this->priceFrom)) {
                $boats = $boats->where('boats.price', '>=', $this->priceFrom);
            }
            if (!empty($this->priceTo)) {
                $boats = $boats->where('boats.price', '<=', $this->priceTo);
            }
        }

        if (!empty($this->lengthFrom) && !empty($this->lengthTo)) {
            $boats = $boats->whereBetween('boats.length', [$this->lengthFrom, $this->lengthTo]);
        } else {
            if (!empty($this->lengthFrom)) {
                $boats = $boats->where('boats.length', '>=', $this->lengthFrom);
            }
            if (!empty($this->lengthTo)) {
                $boats = $boats->where('boats.length', '<=', $this->lengthTo);
            }
        }

        if (!empty($this->selectedBrand)) {
            $boats = $boats->where('brand_id', $this->selectedBrand);
        }
        if (!empty($this->selectedModel)) {
            $boats = $boats->where('boats.model', $this->selectedModel);
        }

        if (!empty($this->selectedCategory)) {
            $boats = $boats->where('boats.category_id', $this->selectedCategory);
        }
        if (!empty($this->selectedBoatCondition)) {
            $boats = $boats->where('boats.boat_condition', $this->selectedBoatCondition);
        }
        if (!empty($this->selectedBoatType)) {
            // print_r($this->selectedBoatType); exit;
            $boats = $boats->where('boats.boat_type', $this->selectedBoatType);
        }

        if(!empty($this->my_favorites)) {
            $favoriteBoatsIds = FavoriteBoat::select('boat_id')
                                ->where('user_id', Auth::user()->id)
                                ->pluck('boat_id')
                                ->toArray();
            $boats = $boats->whereIn('boats.id', $favoriteBoatsIds);
        }

        $excludedBoatsIds = ExcludedBoat::select('boat_id')
                                ->where('user_id', Auth::user()->id)
                                ->pluck('boat_id')
                                ->toArray();

        // if(!empty($this->all_results)) {
        //     $boats = $boats->whereNotIn('boats.id', $excludedBoatsIds);
        // }

        if(!empty($this->my_exclusions)) {
            $boats = $boats->whereIn('boats.id', $excludedBoatsIds);
        }

        if (!empty($this->selectedEngineType)) {
            $boats = $boats->where('engines.engine_type', $this->selectedEngineType);
        }
        if (!empty($this->selectedEngineFuel)) {
            $boats = $boats->where('engines.fuel_type', $this->selectedEngineFuel);
        }

        if (!empty($this->selectedHullMaterial)) {
            $boats = $boats->where('boats.hull_material', $this->selectedHullMaterial);
        }

        if (!empty($this->beam)) {
            $boats = $boats->whereNotNull('other_information.beam_feet');
        }

        if (!empty($this->draft)) {
            $boats = $boats->whereNotNull('other_information.draft');
        }
        if (!empty($this->bridgeClearance)) {
            $boats = $boats->whereNotNull('other_information.bridge_clearance');
        }
        if (!empty($this->LOA)) {
            $boats = $boats->whereNotNull('other_information.LOA');
        }
        if (!empty($this->selectedHead)) {
            $boats = $boats->whereNotNull('other_information.head');
        }
        if (!empty($this->selectedGenerator)) {

            $boats = $boats->where( function($query){
                    $query->whereNotNull('other_information.generator_fuel_type')
                            ->whereNotNull('other_information.generator_size')
                            ->whereNotNull('other_information.generator_hours');
            });

        }
        if (!empty($this->selectedCabin)) {
            $boats = $boats->where( function($query){
                    $query->whereNotNull('other_information.cabin_berths')
                            ->whereNotNull('other_information.cabin_description');
            });
        }
        if (!empty($this->selectedGalley)) {
            $boats = $boats->whereNotNull('other_information.galley_description');
        }

        $boats = $boats->with(['boatInfo', 'engines', 'engine', 'images']);

        if(!empty($this->engineCount)) {
            $boats = $boats->get();
            $boats = $boats->filter(function($item) {
                if(count($item->engines) == $this->engineCount)
                {
                    return $item;
                }
            });
        } else {
            $boats = $boats->get();
        }

        $boats = ColectionPaginate::paginate($boats, 10)->onEachSide(0);
        
        if(!empty($this->viewType)){
            $dispatchData = ['view' => $this->viewType];
        }

        $this->dispatchBrowserEvent('livewire-list-updated', $dispatchData);
        return view('livewire.boats', [
            'boats' => $boats,
            'brands' => Brand::where('is_active','Y')->orderBy('name')->get(),
            'models' => $this->models,
            // 'categories' => $this->categories,
            'defaultConfig' => config('yatchfindr.defaults'),
            'hullMaterials' => Option::where('option_type','hull_material')->where('is_active','Y')->orderBy('name')->get(),
            // 'categories' => Category::where('is_active','Y')->orderBy('name')->get(),
            'boatTypes' => Option::where('option_type','boat_type')->where('is_active','Y')->orderBy('name')->get()
        ]);
    }
}
