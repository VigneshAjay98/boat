<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Http\Interfaces\UserRepositoryInterface',
            'App\Http\Repositories\UserRepository',
        );
        $this->app->bind(

            'App\Http\Interfaces\BrandRepositoryInterface',
            'App\Http\Repositories\BrandRepository',
        );
        $this->app->bind(
            'App\Http\Interfaces\OptionRepositoryInterface',
            'App\Http\Repositories\OptionRepository'
        );
        $this->app->bind(
            'App\Http\Interfaces\ModelRepositoryInterface',
            'App\Http\Repositories\ModelRepository'
        );
        $this->app->bind(
            'App\Http\Interfaces\BoatRepositoryInterface',
            'App\Http\Repositories\BoatRepository'
        );
        $this->app->bind(
            'App\Http\Interfaces\CategoryRepositoryInterface',
            'App\Http\Repositories\CategoryRepository'
        );
        $this->app->bind(
            'App\Http\Interfaces\PlanRepositoryInterface',
            'App\Http\Repositories\PlanRepository'
        );
        $this->app->bind(
            'App\Http\Interfaces\BasicInfoRepositoryInterface',
            'App\Http\Repositories\BasicInfoRepository'
        );
        $this->app->bind(
            'App\Http\Interfaces\DetailsRepositoryInterface',
            'App\Http\Repositories\DetailsRepository'
        );
        $this->app->bind(
            'App\Http\Interfaces\SecondDetailsRepositoryInterface',
            'App\Http\Repositories\SecondDetailsRepository'
        );
        $this->app->bind(
            'App\Http\Interfaces\BoatLocationRepositoryInterface',
            'App\Http\Repositories\BoatLocationRepository'
        );
        $this->app->bind(
            'App\Http\Interfaces\CouponRepositoryInterface',
            'App\Http\Repositories\CouponRepository'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
