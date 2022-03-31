<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Interfaces\BoatRepositoryInterface;

use App\Models\BrandModel;
use App\Models\Option;
use App\Models\Brand;

class HomeController extends Controller
{
    private $boatRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BoatRepositoryInterface $boatRepository
    ) {
        $this->boatRepository = $boatRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $locations = [];
        $brands = Brand::isActive()->pluck('name', 'slug');
        $models = BrandModel::isActive()->pluck('model_name', 'slug');
        $bodyTypes = Option::whereOptionType('boat_type')->isActive()->pluck('name', 'uuid');
        return view('welcome', compact(['brands', 'models', 'bodyTypes']));
    }
}
