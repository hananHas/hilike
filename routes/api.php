<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\LikesController;
use App\Http\Controllers\Api\BlocksController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\PlansController;
use App\Http\Controllers\Api\GiftsController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\SupportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['namespace' => 'Api'], function () {

	Route::get('onboarding/{language}', [HomeController::class, 'onboarding']);
	Route::get('privacy_policy', [HomeController::class, 'privacy_policy']);
	Route::get('about_us', [HomeController::class, 'about_us']);
	Route::get('usage_policy', [HomeController::class, 'usage_policy']);
	Route::get('register_data/{language}', [AuthController::class, 'register_data']);
	
	
    Route::group(['prefix' => 'auth'], function(){
		
		Route::post('register', [AuthController::class, 'register']);
		Route::post('verify', [AuthController::class, 'verify']);
		Route::post('resend_code', [AuthController::class, 'resend_code']);
		Route::post('login', [AuthController::class, 'login']);
		Route::post('forgot', [AuthController::class, 'forgot']);
		Route::get('reset/{token}', [AuthController::class, 'find']);
		Route::post('reset', [AuthController::class, 'reset']);
		Route::post('logout', [AuthController::class, 'logout'])->middleware(['auth:api']);
		Route::post('social_login/{provider}', [AuthController::class, 'socialLogin']);
		
    	// Route::post('social/{provider}', 'AuthController@socialLogin');
		
	});

	Route::middleware(['auth:api','is-ban'])->group(function () {
		Route::get('home', [HomeController::class, 'index']);
		Route::get('see_all_vip', [HomeController::class, 'see_all_vip']);
		Route::get('see_all_special_people', [HomeController::class, 'see_all_special_people']);
		Route::get('see_all_new_people', [HomeController::class, 'see_all_new_people']);
		//subscription
		Route::get('free_trial/{plan_id}', [PlansController::class, 'free_trial']);
		Route::get('plans', [PlansController::class, 'index']);

		//search
		Route::get('search_filters', [SearchController::class, 'search_filters']);
		Route::get('filtering', [SearchController::class, 'filtering']);
		Route::get('standard_filters', [SearchController::class, 'standard_filters']);
		Route::get('search_results', [SearchController::class, 'search_results']);
		//likes
		Route::get('add_like/{user_id}', [LikesController::class, 'add_like']);
		Route::get('remove_like/{user_id}', [LikesController::class, 'remove_like']);
		Route::get('liked_you', [LikesController::class, 'liked_you']);
		Route::get('my_likes', [LikesController::class, 'my_likes']);
		//blocks
		Route::get('add_block/{user_id}', [BlocksController::class, 'add_block']);
		Route::get('remove_block/{user_id}', [BlocksController::class, 'remove_block']);
		Route::get('my_blocks', [BlocksController::class, 'my_blocks']);
		//profile
		Route::get('user_profile/{user_id}', [ProfileController::class, 'user_profile']);
		Route::get('my_profile', [ProfileController::class, 'my_profile']);
		Route::get('edit_profile', [ProfileController::class, 'edit_profile']);
		Route::post('update_profile', [ProfileController::class, 'update_profile']);
		Route::get('delete_image/{image_id}', [ProfileController::class, 'delete_image']);
		Route::get('user_images/{user_id}', [ProfileController::class, 'user_images']);
		Route::get('my_received_gifts', [ProfileController::class, 'my_received_gifts']);
		Route::get('get_report_reasons', [ProfileController::class, 'get_report_reasons']);
		Route::post('report_user', [ProfileController::class, 'report_user']);
		
		//settings
		Route::get('enable_location/{value}', [SettingController::class, 'enable_location']);
		Route::get('show_account/{value}', [SettingController::class, 'show_account']);
		Route::get('switch_language/{value}', [SettingController::class, 'switch_language']);
		Route::post('change_password', [SettingController::class, 'change_password']);
		//gifts
		Route::get('gifts_with_categories', [GiftsController::class, 'gifts_with_categories']);
		Route::get('get_gift/{id}', [GiftsController::class, 'get_gift']);
		Route::get('get_coins', [GiftsController::class, 'get_coins']);
		Route::get('get_balance', [GiftsController::class, 'get_balance']);
		Route::get('send_gift/{gift_id}/{user_id}', [GiftsController::class, 'send_gift']);
		//chat
		Route::get('check_for_thread/{first}', [ChatController::class, 'check_for_thread']);
		Route::post('create_thread', [ChatController::class, 'create_thread']);
		Route::get('get_user_threads', [ChatController::class, 'get_user_threads']);
		Route::get('search_chats/{query}', [ChatController::class, 'search_chats']);
		Route::get('is_online/{id}', [ChatController::class, 'is_online']);
		//support
		Route::get('choose_chat_cat/{cat_id}/{thread_id}', [SupportController::class, 'choose_chat_cat']);
		Route::get('get_support_categories', [SupportController::class, 'get_support_categories']);
		Route::post('upload_chat_image', [SupportController::class, 'upload_chat_image']);
		//share
		Route::get('share_app/{type}', [HomeController::class, 'share_app']);
		//notifications_edit
		Route::get('edit_notifications', [HomeController::class, 'edit_notifications']);
		Route::get('change_notification_status/{type}', [HomeController::class, 'change_notification_status']);
		

		Route::get('plan_payment_form/{plan_id}/{method}', [HomeController::class, 'plan_payment_form']);
		Route::get('coin_payment_form/{coin_id}/{method}', [GiftsController::class, 'coin_payment_form']);

		Route::post('get_users_data', [HomeController::class, 'get_users_data']);
		
	});
	//contact
	Route::post('contact_message', [SupportController::class, 'contact_message']);


// });
