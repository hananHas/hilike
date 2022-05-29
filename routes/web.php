<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReligionController;
use App\Http\Controllers\Admin\SocialTypesController;
use App\Http\Controllers\Admin\MarriageTypesController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\SkinColorsController;
use App\Http\Controllers\Admin\BodyController;
use App\Http\Controllers\Admin\JobsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Admin\ReviewingImagesController;
use App\Http\Controllers\Admin\GiftsController;
use App\Http\Controllers\Admin\GiftsCategoriesController;
use App\Http\Controllers\Admin\CoinsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\SubscriptionsController;
use App\Http\Controllers\Admin\ChatsController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\NotificationsController;
use App\Http\Controllers\Admin\ReviewTextController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function () {
//     return redirect('/login');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Route::get('login', function () {
//     return view('admin.login');
// })->name('login');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function(){

    Route::resources([
        'religions' => ReligionController::class,
        'social_types' => SocialTypesController::class,
        'marriage_types' => MarriageTypesController::class,
        'education' => EducationController::class,
        'skin_colors' => SkinColorsController::class,
        'body_shapes' => BodyController::class,
        'jobs' => JobsController::class,
        'users' => UsersController::class,
        'gifts' => GiftsController::class,
        'gifts_categories' => GiftsCategoriesController::class,
        'coins' => CoinsController::class,
        'subscriptions' => SubscriptionsController::class,
        'roles' => RolesController::class,
        'admins' => AdminsController::class,
        
    ]);
    //onboarding
    Route::get('onboarding', [SettingsController::class, 'onboarding'])->name('onboarding.index');
    Route::get('onboarding/edit/{id}', [SettingsController::class, 'edit_onboarding'])->name('onboarding.edit');
    Route::put('onboarding/update/{id}', [SettingsController::class, 'update_onboarding'])->name('onboarding.update');
    //user management
    Route::get('users_ajax', [UsersController::class, 'get_data']);
    Route::get('block_user/{id}', [UsersController::class, 'block_user']);
    Route::get('revoke_user/{id}', [UsersController::class, 'revoke']);
    Route::get('user_subscriptions/{id}', [UsersController::class, 'user_subscriptions'])->name('users.subscriptions');
    Route::get('user_coins/{id}', [UsersController::class, 'user_coins'])->name('users.coins');
    //about us
    Route::get('about_us', [SettingsController::class, 'about_us'])->name('settings.about_us');
    Route::put('about_us/update', [SettingsController::class, 'update_about_us'])->name('about_us.update');
    //usage policy
    Route::get('usage_policy', [SettingsController::class, 'usage_policy'])->name('settings.usage_policy');
    Route::put('usage_policy/update', [SettingsController::class, 'update_usage_policy'])->name('usage_policy.update');
    //privacy policy
    Route::get('privacy_policy', [SettingsController::class, 'privacy_policy'])->name('settings.privacy_policy');
    Route::put('privacy_policy/update', [SettingsController::class, 'update_privacy_policy'])->name('privacy_policy.update');
    //reports
    Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::delete('delete_report/{id}', [ReportsController::class, 'delete_report'])->name('reports.delete');
    //plans
    Route::get('plans', [PlansController::class, 'index'])->name('plans.index');
    Route::get('plans/edit_price/{id}', [PlansController::class, 'edit_price'])->name('plans.edit_price');
    Route::put('plans/update/{id}', [PlansController::class, 'update'])->name('plans.update');
    Route::get('plans/packages/{id}', [PlansController::class, 'packages'])->name('plans.packages');
    Route::post('plans/packages_add/{id}', [PlansController::class, 'add_packages'])->name('plans.packages.add');
    Route::delete('plans/packages_delete/{id}', [PlansController::class, 'delete_package'])->name('plans.packages.delete');
    //review images
    Route::get('images/review_profile', [ReviewingImagesController::class, 'profile_images_list'])->name('images.review_profile');
    Route::get('images_other/review_other', [ReviewingImagesController::class, 'other_images_list'])->name('images.review_other');
    Route::get('accept_or_reject/{image}/{type}/{id}', [ReviewingImagesController::class, 'accept_or_reject']);
    //review texts
    Route::get('nicknames', [ReviewTextController::class, 'nicknames'])->name('texts.nicknames');
    Route::get('looking_for', [ReviewTextController::class, 'looking_for'])->name('texts.looking_for');
    Route::get('about_user', [ReviewTextController::class, 'about_user'])->name('texts.about_user');
    Route::get('accept/{type}/{id}', [ReviewTextController::class, 'accept']);
    Route::put('update/{type}/{id}', [ReviewTextController::class, 'update'])->name('texts.update');
    Route::get('reject/{type}/{id}', [ReviewTextController::class, 'reject']);
    //subscriptions
    Route::get('subscriptions_ajax', [SubscriptionsController::class, 'get_data']);
    //analytics
    Route::get('analytics_users', [HomeController::class, 'users_analytics'])->name('analytics.users');
    Route::get('analytics_incomes', [HomeController::class, 'incomes_analytics'])->name('analytics.incomes');
    Route::get('analytics_interactions', [HomeController::class, 'interactions_analytics'])->name('analytics.interactions');
    Route::get('analytics_incomes/data', [HomeController::class, 'incomes_data'])->name('analytics.incomes_data');
    Route::get('analytics_interactions/data', [HomeController::class, 'interactions_data'])->name('analytics.interactions_data');
    //chats monitoring
    Route::get('chats', [ChatsController::class, 'chats'])->name('chats.index');
    Route::get('get_chat/{thread_id}', [ChatsController::class, 'get_chat'])->name('chats.show');
    //support
    Route::get('/chats_list',[SupportController::class, 'page'])->name('chats.view');
    Route::get('/chat_details/{thread_id}',[SupportController::class, 'get_chat'])->name('chat.view');
    Route::get('/contact',[SupportController::class, 'contact'])->name('contact.index');
    //notifications
    Route::get('notifications', [NotificationsController::class, 'notifications'])->name('notifications.index');
    Route::get('notifications/add', [NotificationsController::class, 'add_notifications'])->name('notifications.create');
    Route::post('notifications/store', [NotificationsController::class, 'store_notifications'])->name('notifications.store');
    //app links
    Route::get('app_links', [HomeController::class, 'app_links'])->name('app_links.index');
    Route::post('app_links/update', [HomeController::class, 'update_app_links'])->name('app_links.update');
});
// payment routes
Route::get('payment_form/{user}/{plan_id}/{package_id}', [PaymentController::class, 'show_payment_form'])->name('plan.form');
Route::post('plan/{id}/pay', [PaymentController::class, 'purchase'])->name('plan.pay');
Route::get('show_coins_payment_form/{user}/{coin_id}', [PaymentController::class, 'show_coins_payment_form'])->name('coin.form');
Route::post('coin/{id}/pay', [PaymentController::class, 'purchase_coin'])->name('coin.pay');

Route::get('success/payment/{coins}/{user_id}', [PaymentController::class, 'success_payment'])->name('payment.success');
Route::get('success/payment/plan/{plan_id}/{user_id}', [PaymentController::class, 'plan_success_payment'])->name('plan.payment.success');
Route::get('error/payment', [PaymentController::class, 'error_payment'])->name('payment.error');
Route::get('payment_status', [PaymentController::class, 'payment_status']);


