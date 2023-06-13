<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/',[App\Http\Controllers\Front\HomeController::class,'index']);

Route::prefix('shop')->group(function (){
    Route::get('product/{id}',[App\Http\Controllers\Front\ShopController::class,'show']);
    Route::post('product/{id}',[App\Http\Controllers\Front\ShopController::class,'postComment']);
    Route::get('',[App\Http\Controllers\Front\ShopController::class,'index']);
    Route::get('category/{categoryName}',[App\Http\Controllers\Front\ShopController::class,'category']);
});

Route::prefix('cart')->group(function (){
    Route::get('add', [App\Http\Controllers\Front\CartController::class,'add']);
    Route::get('addCartInDetails', [App\Http\Controllers\Front\CartController::class,'addCartInDetails']);
    Route::get('/', [App\Http\Controllers\Front\CartController::class,'index']);
    Route::get('delete', [App\Http\Controllers\Front\CartController::class,'delete']);
    Route::get('destroy', [App\Http\Controllers\Front\CartController::class,'destroy']);
    Route::get('update', [App\Http\Controllers\Front\CartController::class,'update']);
});
Route::prefix('wishlist')->group(function (){
    Route::get('add', [App\Http\Controllers\Front\WishlistController::class,'add']);
    Route::get('/', [App\Http\Controllers\Front\WishlistController::class,'index']);
    Route::get('delete', [App\Http\Controllers\Front\WishlistController::class,'delete']);
//    Route::get('destroy', [App\Http\Controllers\Front\CartController::class,'destroy']);
//    Route::get('update', [App\Http\Controllers\Front\CartController::class,'update']);
});

Route::prefix('checkout')->middleware('CheckMemberLogin')->group(function (){
    Route::get('',[App\Http\Controllers\Front\CheckOutController::class,'index']);
    Route::post('/',[App\Http\Controllers\Front\CheckOutController::class,'addOrder']);
    Route::post('/apply_coupon_code',[App\Http\Controllers\Front\CheckOutController::class,'apply_coupon_code']);
    Route::post('/remove_coupon_code',[App\Http\Controllers\Front\CheckOutController::class,'remove_coupon_code']);
    Route::get('/result',[App\Http\Controllers\Front\CheckOutController::class,'result']);
    Route::get('/vnPayCheck',[App\Http\Controllers\Front\CheckOutController::class,'vnPayCheck']);
    Route::get('/discount-codes', function () {
        $discountCodes = \App\Models\Coupon::all();

        return response()->json(['discount_codes' => $discountCodes]);
    });
});

Route::prefix('account')->group(function (){
    Route::get('login',[App\Http\Controllers\Front\AccountController::class,'login']);
    Route::post('login',[App\Http\Controllers\Front\AccountController::class,'checkLogin']);

    Route::get('logout',[App\Http\Controllers\Front\AccountController::class,'logout']);

    Route::get('register',[App\Http\Controllers\Front\AccountController::class,'register']);
    Route::post('register',[App\Http\Controllers\Front\AccountController::class,'postRegister']);

    Route::prefix('my-order')->middleware('CheckMemberLogin')->group(function (){
        Route::get('/',[App\Http\Controllers\Front\AccountController::class,'myOrderIndex']);
        Route::get('{id}',[App\Http\Controllers\Front\AccountController::class,'myOrderShow']);
        Route::get('{id}/cancel',[App\Http\Controllers\Front\AccountController::class,'cancelOrder']);
    });

    Route::prefix('profile')->middleware('CheckMemberLogin')->group(function (){
        Route::get('/',[App\Http\Controllers\Front\AccountController::class,'indexProfile']);
        Route::post('/',[App\Http\Controllers\Front\AccountController::class,'postEditProfile']);
    });
    Route::prefix('coupons')->middleware('CheckMemberLogin')->group(function (){
        Route::get('/',[App\Http\Controllers\Front\AccountController::class,'couponsIndex']);
    });
    Route::prefix('changepassword')->middleware('CheckMemberLogin')->group(function (){
        Route::get('/',[App\Http\Controllers\Front\AccountController::class,'indexPass']);
        Route::post('/',[App\Http\Controllers\Front\AccountController::class,'postChangePassword']);
    });
});

//ADMIN
Route::prefix('admin')->middleware('CheckAdminLogin')->group(function (){
    Route::redirect('','admin/dashboard');

    Route::resource('user',App\Http\Controllers\Admin\UserController::class);
    Route::resource('coupon',App\Http\Controllers\Admin\CouponController::class);
    Route::resource('dashboard',App\Http\Controllers\Admin\DashboardController::class);
    Route::post('dashboard/filter-by-date',[App\Http\Controllers\Admin\DashboardController::class,'filter_by_date']);
    Route::post('dashboard/dashboard-filter',[App\Http\Controllers\Admin\DashboardController::class,'dashboard_filter']);
    Route::post('dashboard/day-order',[App\Http\Controllers\Admin\DashboardController::class,'day_order']);
    Route::resource('category',App\Http\Controllers\Admin\ProductCategoryController::class);
    Route::resource('brand',App\Http\Controllers\Admin\BrandController::class);
    Route::resource('product',App\Http\Controllers\Admin\ProductController::class);
    Route::resource('product/{product_id}/image',App\Http\Controllers\Admin\ProductImageController::class);
    Route::resource('product/{product_id}/detail',App\Http\Controllers\Admin\ProductDetailController::class);
    Route::resource('order',App\Http\Controllers\Admin\OrderController::class);
    Route::resource('productcomment',App\Http\Controllers\Admin\ProductCommentController::class);

    Route::prefix('login')->group(function (){
        Route::get('',[App\Http\Controllers\Admin\HomeController::class,'getLogin'])->withoutMiddleware('CheckAdminLogin');
        Route::post('',[App\Http\Controllers\Admin\HomeController::class,'postLogin'])->withoutMiddleware('CheckAdminLogin');
    });
    Route::get('logout',[App\Http\Controllers\Admin\HomeController::class,'logout']);
});
