
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/switch-currency/{currency}/{country}', function ($currency, $country) {
    if(isset($currency) && isset($country)){
        session(['USER_CURRENCY' => $currency]);
        session(['USER_COUNTRY' => $country]);
        $this->success('Country set successfully!')->push();
        return response()->json([
            'status' => 'success',
            'message' => 'Country set successfully!'
        ], 200);
    } else {
        $this->error('Failed to set country!')->push();
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to set country!'
        ], 422);
    }
 });

Route::prefix('scrapper')->group(function() {
    Route::get('/categories', [App\Http\Controllers\ScraperController::class, 'index']);
});


Route::prefix('pages')->group(function() {
    Route::get('/about-us', [App\Http\Controllers\PageController::class, 'about'])->name('about-us');
});
// Route::get('sell-boats', [App\Http\Controllers\BoatController::class, 'index'])->name('general-info'); // Sell boat form
Route::get('error-404', [App\Http\Controllers\ListingController::class, 'errorPage']); // Error page 404
Route::get('yacht-information', [App\Http\Controllers\ListingController::class, 'boatInformation']); // Show Boat Information
Route::get('/front/about-us', [App\Http\Controllers\ListingController::class, 'aboutUs']); // About us page
Route::get('contact-us', [App\Http\Controllers\ListingController::class, 'contactUs'])->name('contact-us'); // Contact us page

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// All the listings pages
Route::prefix('explore')->group(function() {

    // Boats Listing
    Route::get('/yachts', [App\Http\Controllers\ListingController::class, 'showBoatListings'])->name('explore-yachts'); // Show Boats by catalogue
    Route::get('/yachts/grid', [App\Http\Controllers\ListingController::class, 'showBoatGridListings']); // Show Boats by grid
    Route::get('/yacht/{slug}', [App\Http\Controllers\ListingController::class, 'showBoat'])->name('show-boat');// Show boat information

    //Brands Listings
    Route::get('/brands', [App\Http\Controllers\ListingController::class, 'showBrandsListings'])->name('explore-brands'); // Show brands
    Route::get('/brand/{slug}', [App\Http\Controllers\ListingController::class, 'showBrand'])->name('show-brand');// Show brand information

    Route::get('/categories', [App\Http\Controllers\ListingController::class, 'showCategoriesListings'])->name('explore-categories'); // Show categories
    Route::get('/category/{slug}', [App\Http\Controllers\ListingController::class, 'showCategory'])->name('show-category');// Show brand information

});


Route::get('/get-plan-AddOn/{uuid}', [App\Http\Controllers\PlanController::class, 'getPlanAddOns']);
Route::get('/get-type-category/{boatType}', [App\Http\Controllers\BoatController::class, 'getTypeCategories']);
Route::get('/get-brand-models/{uuid}', [App\Http\Controllers\BoatController::class, 'getBrandModels']);
Route::get('/get-states/{country}', [App\Http\Controllers\BoatController::class, 'getStates']);
Route::get('/get-images/{uuid}', [App\Http\Controllers\BoatController::class, 'getBoatImages']);
Route::get('/get-videos/{uuid}', [App\Http\Controllers\BoatController::class, 'getBoatVideos']);
Route::get('/verify-coupon/{coupon}', [App\Http\Controllers\PlanController::class, 'verifyCoupon']);
Route::get('/remove-coupon', [App\Http\Controllers\PlanController::class, 'removeCoupon']);

Route::get('/livewire-listing', [App\Http\Controllers\ListingController::class, 'livewireListing'])->name('livewire-listing');// Show boat information

Route::get('/email-verification/{uuid}', [App\Http\Controllers\UserController::class, 'verifyEmail']);
Route::post('/email-to-yacht-seller', [App\Http\Controllers\UserController::class, 'emailToBoatSeller'])->name('email-to-yacht-seller'); // Show Boats by grid

// Route::get('/', ['middleware' => 'auth', function () {
//     return view('auth.login');
// }]);
Auth::routes();
Route::group(['middleware' => ['auth', 'user']], function () {
    Route::get('/select-plan', [App\Http\Controllers\PlanController::class, 'index'])->name('select-plan'); // Select plans page
    Route::get('profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile'); // Show Personal Information
    Route::get('security', [App\Http\Controllers\UserController::class, 'security'])->name('security'); // Show Personal Information
    Route::put('update-password', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('update-password');
    Route::put('/update-profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('update-profile');

    Route::get('/favorite-yachts', [App\Http\Controllers\UserController::class, 'showAllFavoriteBoat'])->name('favorite-yachts'); // Show favorite boat listings
    Route::post('/remove-favorite-yacht', [App\Http\Controllers\UserController::class, 'removeFavoriteBoat'])->name('remove-favorite-yacht'); // Show block boat listings

    Route::get('/user-yachts', [App\Http\Controllers\ListingController::class, 'userBoats'])->name('user-yachts'); // Show lists of personal boats
    Route::get('/my-yachts', [App\Http\Controllers\UserController::class, 'myBoats'])->name('my-yachts'); // Show lists of personal boats
    Route::get('/blocked-yachts', [App\Http\Controllers\UserController::class, 'blockedBoats'])->name('blocked-yachts'); // Show block boat listings
    Route::post('/unblocked-yacht', [App\Http\Controllers\UserController::class, 'unblockedBoat'])->name('unblocked-yachts'); // Show block boat listings

    Route::get('/my-orders', [App\Http\Controllers\UserController::class, 'myOrders'])->name('my-orders'); // Show lists of orders
    Route::get('/my-orders-list', [App\Http\Controllers\UserController::class, 'myOrdersList'])->name('my-orders-list'); // Get User Orders
    Route::get('/my-yacht/{slug}', [App\Http\Controllers\UserController::class, 'showBoat'])->name('my-yacht'); // Show  personal boat information
    Route::post('/select-plan', [App\Http\Controllers\PlanController::class, 'choosePlan'])->name('select-plan'); // Show Boats by grid
    /*Sell Your Boat Create/Edit*/
    Route::get('/listing/step-one', [App\Http\Controllers\BoatController::class, 'stepOne'])->name('step-one');
    Route::post('/listing/step-one', [App\Http\Controllers\BoatController::class, 'storeStepOne'])->name('step-one-submit'); // Step one submit form
    Route::get('/listing/step-two', [App\Http\Controllers\BoatController::class, 'stepTwo'])->name('step-two');
    Route::post('/listing/step-two', [App\Http\Controllers\BoatController::class, 'storeStepTwo'])->name('step-two-submit'); // Step two submit form
    Route::get('/listing/step-three', [App\Http\Controllers\BoatController::class, 'stepThree'])->name('step-three');
    Route::post('/listing/step-three', [App\Http\Controllers\BoatController::class, 'storeStepThree'])->name('step-three-submit'); // Step three submit form
    Route::get('/listing/step-four', [App\Http\Controllers\BoatController::class, 'stepFour'])->name('step-four');
    Route::post('/listing/step-four', [App\Http\Controllers\BoatController::class, 'storeStepFour'])->name('step-four-submit'); // Step four submit form
    Route::get('/listing/step-five', [App\Http\Controllers\BoatController::class, 'stepFive'])->name('step-five');// Step five form
    Route::post('/listing/step-five', [App\Http\Controllers\OrderController::class, 'processPayment'])->name('step-five-submit'); // Step five submit form
    Route::post('/listing/subscribe-free-boat', [App\Http\Controllers\OrderController::class, 'storeStepFive'])->name('free-boat-subscribe'); // Step five submit form
    Route::post('/confirm-payment', [App\Http\Controllers\OrderController::class, 'confirmPayment'])->name('confirm-payment'); // Step five submit form
    Route::get('/payment-success', [App\Http\Controllers\OrderController::class, 'paymentSuccess'])->name('payment-success'); // Step five submit form
    Route::post('/cancel-subscription/{subscriptionName}', [App\Http\Controllers\OrderController::class, 'cancelSubscription'])->name('cancel-subscription'); // Cancel Subscription
    Route::post('/delete-yacht/{uuid}', [App\Http\Controllers\BoatController::class, 'deleteYacht'])->name('delete-yacht'); // Delete Yacht

    Route::get('test', [App\Http\Controllers\OrderController::class, 'test']); // Step five submit form

    Route::post('/favorite-yacht', [App\Http\Controllers\ListingController::class, 'addToFavoriteBoat'])->name('favorite-yacht'); // Make boat as favorite
    Route::post('/block-yacht', [App\Http\Controllers\ListingController::class, 'blockBoat'])->name('block-yacht');
    Route::post('/exclude-yacht', [App\Http\Controllers\ListingController::class, 'excludeBoat'])->name('exclude-yacht');
    Route::post('/unexclude-yacht', [App\Http\Controllers\UserController::class, 'unexcludeBoat'])->name('unexclude-yacht');

});

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
        Route::resource('/users', App\Http\Controllers\Admin\UserController::class);
        Route::get('/users-list', [App\Http\Controllers\Admin\UserController::class, 'usersList']);
        Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index']);
        Route::resource('options', App\Http\Controllers\Admin\OptionController::class);
        Route::get('/options-list', [App\Http\Controllers\Admin\OptionController::class, 'optionsList']);
        Route::get('/option-status/{uuid}', [App\Http\Controllers\Admin\OptionController::class, 'status']);
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
        Route::get('/categories-list', [App\Http\Controllers\Admin\CategoryController::class, 'categoriesList']);
        Route::get('/category-status/{uuid}', [App\Http\Controllers\Admin\CategoryController::class, 'status']);

        Route::resource('/brands', App\Http\Controllers\Admin\BrandController::class);
        Route::get('/brands-list', [App\Http\Controllers\Admin\BrandController::class, 'brandsList']);
        Route::get('/brands-status/{uuid}/{status}', [App\Http\Controllers\Admin\BrandController::class, 'brandsStatus']);

        Route::resource('/models', App\Http\Controllers\Admin\ModelController::class);
        Route::get('/models-list', [App\Http\Controllers\Admin\ModelController::class, 'modelsList']);
        Route::get('/models-status/{uuid}/{status}', [App\Http\Controllers\Admin\ModelController::class, 'modelsStatus']);

        Route::resource('/coupons', App\Http\Controllers\Admin\CouponController::class);
        Route::get('/coupons-list', [App\Http\Controllers\Admin\CouponController::class, 'couponsList']);

        Route::resource('/plans', App\Http\Controllers\Admin\PlanController::class);
        Route::get('/plans-list', [App\Http\Controllers\Admin\PlanController::class, 'plansList']);
        Route::get('/plan-video-required-status/{uuid}', [App\Http\Controllers\Admin\PlanController::class, 'status']);

        Route::resource('/plan-addons', App\Http\Controllers\Admin\PlanAddonController::class);
        Route::get('/plan-addons-list', [App\Http\Controllers\Admin\PlanAddonController::class, 'planAddonsList']);


        Route::get('/me', [App\Http\Controllers\Admin\UserController::class, 'profile'])->name('me');
        Route::put('/me', [App\Http\Controllers\Admin\UserController::class, 'profileUpdate'])->name('saveProfile');

});

Route::group(['middleware' => 'check_role:admin,super_admin', 'prefix' => 'admin', ], function () {

});

