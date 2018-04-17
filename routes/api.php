<?php

use Illuminate\Http\Request;

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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::group(['middleware' => ['api','cors']], function () {
    Route::post('reserveregister', 'Api\AuthapiController@reserveregister');

    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', 'Api\AuthapiController@register');
        Route::post('forgotpassword', 'EmailController@sendResetPWDEmail');
        Route::post('resetcode', 'Api\AuthapiController@ConfirmResetPWDcode');
        Route::post('resetpwd', 'Api\AuthapiController@ResetPwd');
        Route::post('login', 'Api\AuthapiController@login');
        Route::post('changepassword', 'Api\AuthapiController@changepassword');
    });

    Route::group(['middleware' => 'jwt-auth'], function () {
        Route::post('changepassword', 'Api\AuthapiController@changepassword');

        Route::group(['prefix' => 'user'], function () {
            Route::post('details', 'Api\AuthapiController@userdetails');
            Route::post('updateuser', 'Api\AuthapiController@updateuserinfo');


            Route::group(['prefix' => 'upload'], function () {
                Route::post('profilepic', 'Api\PicuploadController@uploaduserprofilepic');
                Route::post('initialpic', 'Api\PicuploadController@uploadinitialpic');
            });
        });

        Route::group(['prefix' => 'program'], function () {
            Route::post('setstartdate', 'Api\ProgramapiController@setstartdate');
            Route::post('resetworkout', 'Api\ProgramapiController@resetworkout');
            Route::post('resetnutrition', 'Api\ProgramapiController@resetnutrition');
            Route::post('updateprograminfo', 'Api\ProgramapiController@updateuserprograminfo');
            Route::post('updateworkoutinfo', 'Api\ProgramapiController@updateuserworkoutinfo');
            Route::post('updatenutritioninfo', 'Api\ProgramapiController@updateusernutritioninfo');
            Route::post('setactive', 'Api\ProgramapiController@setactiveprogram');
            Route::post('setactivenutrition', 'Api\ProgramapiController@setactivenutrition');
        });
    });


});