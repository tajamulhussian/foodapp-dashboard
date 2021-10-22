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

Auth::routes(['register'=>false]);

Route::get('user/login','FrontendController@login')->name('login.form');
Route::post('user/login','FrontendController@loginSubmit')->name('login.submit');
Route::get('user/logout','FrontendController@logout')->name('user.logout');

// Route::get('user/register','FrontendController@register')->name('register.form');
// Route::post('user/register','FrontendController@registerSubmit')->name('register.submit');
// // Reset password
// Route::post('password-reset', 'FrontendController@showResetForm')->name('password.reset'); 
// // Socialite 
// Route::get('login/{provider}/', 'Auth\LoginController@redirect')->name('login.redirect');
// Route::get('login/{provider}/callback/', 'Auth\LoginController@Callback')->name('login.callback');

Route::get('/','FrontendController@home')->name('home');

// Frontend Routes
 Route::get('/home', 'FrontendController@index');


Route::group(['prefix'=>'/admin','middleware'=>['auth','admin']],function(){
    Route::get('/','AdminController@index')->name('admin');
    Route::get('/file-manager',function(){
        return view('backend.layouts.file-manager');
    })->name('file-manager');
    // user route
    Route::resource('users','UsersController');
    // Banner
    Route::resource('banner','BannerController');
    // Brand
    Route::resource('brand','BrandController');
    // Profile
    Route::get('/profile','AdminController@profile')->name('admin-profile');
    Route::post('/profile/{id}','AdminController@profileUpdate')->name('profile-update');
    // Menu
    Route::get('/menu','MenuController@index')->name('admin-menu');
    Route::get('/add_menu','MenuController@create')->name('admin-add_menu');
    Route::post('/store_menu','MenuController@store')->name('admin-store_menu');
    Route::post('/delete_menu','MenuController@delete')->name('admin-delete_menu');
    Route::get('/edit_menu/{id}','MenuController@edit')->name('admin-edit_menu');
    Route::post('/update_menu/{id}','MenuController@update')->name('admin-delete_menu');

    // Category
    Route::resource('/category','CategoryController');
    Route::delete('category/{id}','CategoryController@destroy')->name('admin-delete_category');
    // Route::post('/edit_category/{id}','CategoryController@edit')->name('admin-edit_menu');
    // Product
    Route::resource('/product','ProductController');

    Route::get('/product-option/{id}','ProductController@productsOptions');
   

    Route::get('/create-option/{id}','ProductController@createOption');
    Route::post('/store-option','ProductController@StoreOptions');
    Route::get('/edit-option/{id}','ProductController@editOption');
    Route::post('/update-option/{id}','ProductController@updateOption');
    Route::post('/delete-option','ProductController@deleteOption');
    //outlate

    Route::get('/outlate','OutlateController@index')->name('admin-outlate');
    Route::get('/add_outlate','OutlateController@create')->name('admin-add_outlate');
    Route::post('/store_outlate','OutlateController@store')->name('admin-store_outlate');
    Route::post('/delete_outlate','OutlateController@delete')->name('admin-delete_outlate');
    Route::get('/edit_outlate/{id}','OutlateController@edit')->name('admin-edit_outlate');
    Route::post('/update_outlate/{id}','OutlateController@update')->name('admin-update_outlate');
    


    // Ajax for sub category
    Route::post('/category/{id}/child','CategoryController@getChildByParent');
    // POST category
    Route::resource('/post-category','PostCategoryController');
    // Post tag
    Route::resource('/post-tag','PostTagController');
    // Post
    Route::resource('/post','PostController');
    // Message
    Route::resource('/message','MessageController');
    Route::get('/message/five','MessageController@messageFive')->name('messages.five');

    // Order
    Route::resource('/order','OrderController');
    Route::delete('order/{id}','OrderController@destroy')->name('admin-delete_order');
    // Shipping
    Route::resource('/shipping','ShippingController');
    // Coupon
    Route::resource('/coupon','CouponController');
    // Settings
    Route::get('settings','AdminController@settings')->name('settings');
    Route::post('setting/update','AdminController@settingsUpdate')->name('settings.update');

    // Notification
    Route::get('/notification/{id}','NotificationController@show')->name('admin.notification');
    Route::get('/notifications','NotificationController@index')->name('all.notification');
    Route::delete('/notification/{id}','NotificationController@delete')->name('notification.delete');
    // Password Change
    Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');
    Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');
});










// User section start
Route::group(['prefix'=>'/user','middleware'=>['user']],function(){
    Route::get('/','HomeController@index')->name('user');
     // Profile
     Route::get('/profile','HomeController@profile')->name('user-profile');
     Route::post('/profile/{id}','HomeController@profileUpdate')->name('user-profile-update');
    //  Order
    Route::get('/order',"HomeController@orderIndex")->name('user.order.index');
    Route::get('/order/show/{id}',"HomeController@orderShow")->name('user.order.show');
    Route::delete('/order/delete/{id}','HomeController@userOrderDelete')->name('user.order.delete');
    // Product Review
    Route::get('/user-review','HomeController@productReviewIndex')->name('user.productreview.index');
    Route::delete('/user-review/delete/{id}','HomeController@productReviewDelete')->name('user.productreview.delete');
    Route::get('/user-review/edit/{id}','HomeController@productReviewEdit')->name('user.productreview.edit');
    Route::patch('/user-review/update/{id}','HomeController@productReviewUpdate')->name('user.productreview.update');
    
    // Post comment
    Route::get('user-post/comment','HomeController@userComment')->name('user.post-comment.index');
    Route::delete('user-post/comment/delete/{id}','HomeController@userCommentDelete')->name('user.post-comment.delete');
    Route::get('user-post/comment/edit/{id}','HomeController@userCommentEdit')->name('user.post-comment.edit');
    Route::patch('user-post/comment/udpate/{id}','HomeController@userCommentUpdate')->name('user.post-comment.update');
    
    // Password Change
    Route::get('change-password', 'HomeController@changePassword')->name('user.change.password.form');
    Route::post('change-password', 'HomeController@changPasswordStore')->name('change.password');

});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});