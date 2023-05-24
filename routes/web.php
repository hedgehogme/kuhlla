<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

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

Route::get('/', function () {
    return view('welcome');
});
    //  ->middleware('lang');

Route::get('/clear', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('route:cache');
    \Artisan::call('config:cache');
    \Artisan::call('view:clear');
    \Artisan::call('config:clear');
    echo 'clear';
});


Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    /*exec('rm -rf public/storage');
    exec('php artisan storage:link');*/
    echo 'Symlink process successfully completed';
});

Route::post('save_token', [App\Http\Controllers\Controller::class, 'updateToken'])->name('fcmToken');

Route::get('test', [App\Http\Controllers\Controller::class, 'test']);

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
Route::get('deploy', [\App\Http\Controllers\Controller::class, 'deploy']);

Route::view('mail_theame','mail');

Route::get('customer-privacy-policy', [\App\Http\Controllers\API\PrivacyPolicyApiController::class, 'printPrivacyPolicy']);
Route::get('customer-returns-and-exchanges-policy', [\App\Http\Controllers\API\PrivacyPolicyApiController::class, 'printReturnsAndExchangesPolicy']);
Route::get('customer-shipping-policy', [\App\Http\Controllers\API\PrivacyPolicyApiController::class, 'printShippingPolicy']);
Route::get('customer-cancellation-policy', [\App\Http\Controllers\API\PrivacyPolicyApiController::class, 'printCancellationPolicy']);
Route::get('customer-terms-conditions', [\App\Http\Controllers\API\PrivacyPolicyApiController::class, 'printTermsConditions']);

Route::get('delivery-boy-privacy-policy', [\App\Http\Controllers\API\PrivacyPolicyDeliveryBoyApiController::class, 'printPrivacyPolicy']);
Route::get('delivery-boy-terms-conditions', [\App\Http\Controllers\API\PrivacyPolicyDeliveryBoyApiController::class, 'printTermsConditions']);

Route::get('seller-privacy-policy', [\App\Http\Controllers\API\PrivacyPolicyDeliveryBoyApiController::class, 'printPrivacyPolicy']);
Route::get('seller-terms-conditions', [\App\Http\Controllers\API\PrivacyPolicyDeliveryBoyApiController::class, 'printTermsConditions']);

Route::get('manager-privacy-policy', [\App\Http\Controllers\API\PrivacyPolicyManagerAppApiController::class, 'printPrivacyPolicy']);
Route::get('manager-terms-conditions', [\App\Http\Controllers\API\PrivacyPolicyManagerAppApiController::class, 'printTermsConditions']);

Route::get('manager-terms-conditions', [\App\Http\Controllers\API\PrivacyPolicyManagerAppApiController::class, 'printTermsConditions']);

//Webhook
//Route::get('webhook/stripe', [\App\Http\Controllers\StripeController::class, 'stripeWebhook']);
Route::post('webhook/stripe', [\App\Http\Controllers\StripeController::class, 'stripeWebhook']);

//for localization in vuejs
Route::post('api/change_language', [\App\Http\Controllers\Controller::class, 'doLanguageChange'])->name('change_language');

Route::get('/js/lang', function() {
    /*$files   = glob(resource_path('lang/' . $lang . '/*.php'));
    $strings = [];
    foreach ($files as $file) {
        $name           = basename($file, '.php');
        $strings[$name] = require $file;
    }

    header('Content-Type: text/javascript');
    echo('window.i18n = ' . json_encode($strings) . ';');*/

    $lang = config('app.locale');
    $lang = $lang ?? 'en';
    $file = Cache::rememberForever('lang.js', function () {
        $lang = config('app.locale');
        $lang = $lang ?? 'en';
        return file_get_contents(resource_path('lang/' . $lang . '.json'));
    });

    //$file = file_get_contents(resource_path('lang/' . $lang . '.json'));
    header('Content-Type: text/javascript');
    echo('window.i18n = ' . $file);
    exit();
})->name('assets.lang')->withoutMiddleware('auth:sanctum');

/*Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*');*/

/*Route::get('firebase-messaging-sw.js', function() {

    $data = 'importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
             importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");
                firebase.initializeApp({
                    apiKey: "AIzaSyBdDqLlXGn2RXOgnfPJ8ZMjkQ1DWUD7SMM",
                    projectId: "egrocer-457a9",
                    messagingSenderId: "755773183987",
                    appId: "1:755773183987:web:b21f893398fac9c493e486",
                });
            const messaging = firebase.messaging();
            messaging.setBackgroundMessageHandler(function (payload) {
                const notification = JSON.parse(payload.data.data);
                const title = notification.title;
                const options = {
                    body: notification.body,
                    icon: notification.icon,
                };
                return self.registration.showNotification(title, options);
                //return self.registration.showNotification(title,{body,icon});
            });';
    echo $data;
})->name('assets.lang2');*/

Route::get('firebase-messaging-sw.js', [\App\Http\Controllers\API\FirebaseApiController::class, 'firebaseMessagingJsCode'])->name('assets.firebase-messaging-sw');

Route::get('{all}', function () {
    return view('welcome');
})->where('all', '^(?!customer).*$');
