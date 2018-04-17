<?php

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


Auth::routes();


/*--program builder--*/


Route::get('/register/pt', array(
    'as' => 'pt_register',
    'uses' => 'Auth\RegisterController@ptRegisterIndex'
));
Route::get('/about', array(
    'as' => 'about',
    'uses' => 'HomeController@DisplayAbout'
));
Route::get('/terms', array(
    'as' => 'terms',
    'uses' => 'HomeController@TermsService'
));
Route::get('/refund', array(
    'as' => 'refund',
    'uses' => 'HomeController@RefundPolicy'
));

Route::get('/application', array(
    'as' => 'application',
    'uses' => 'HomeController@ApplicationPageIndex'
));

Route::get('/account_settings', array(
    'as' => 'accsettings',
    'uses' => 'AccountSettingsController@AccountSettingsIndex'
));

Route::get('/blog', array(
    'as' => 'blog',
    'uses' => 'BlogController@BlogIndex'
));

Route::get('/fithabitplus', array(
    'as' => 'fithabitplus',
    'uses' => 'FithabitPlusController@FithabitPlusIndex'
));

Route::post('/register/pt', 'Auth\RegisterController@ptRegister');
Route::get('/', function () {
    if(Auth::guest())
    {
        return view('welcome');
    }
    else
    {
        if(Auth::user()->user_type == 0)
        {
            return redirect('/finder');
        }
        else
        {
            return redirect('/dashboard');
        }
    }
});

Route::get('/link/{programlink}', 'FinderController@LinkIndex');
Route::get('/purchaseprogram', array(
    'as' => 'directlink',
    'uses' => 'FinderController@PurchaseIndex'
));


Route::group(['middleware' => 'FitHabit\Http\Middleware\STMiddleware'], function()
{
    Route::post('/purchaseprogram', 'FinderController@PurchaseIndex');

    Route::post('/processpurchase', 'FinderController@PurchaseProcess');
    Route::post('/purchasefinish', 'FinderController@PurchaseFinish');

    Route::get('/finder', 'FinderController@Index');
    Route::get('/finder/workout', 'FinderController@WorkoutIndex');
    Route::get('/finder/nutrition', 'FinderController@NutritionIndex');
    Route::get('/finder/infodoc', 'FinderController@InfodocIndex');
    Route::get('/userprogram', 'FinderController@userprogramIndex');

    Route::get('/programpreview', 'ProgrambuilderController@PreviewProgram');
});

Route::group(['middleware' => 'FitHabit\Http\Middleware\PTMiddleware'], function()
{
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/stripe/connect', 'AccountController@stripeConnect');
    Route::post('/subscription', 'AccountController@CreateSubscription');

    Route::group(['middleware' => 'FitHabit\Http\Middleware\FMiddleware'], function()
    {
        Route::get('/support', 'DashboardController@showSupport');
        Route::get('/accountsetting', 'DashboardController@showaccountsettings');

        Route::get('/myprograms', 'DashboardController@showmyprograms');
        Route::post('/myprograms', 'ProgrambuilderController@getProgramList');
        Route::get('/revenue', 'RevenueController@revenueIndex');
        Route::get('/signuplist', 'DashboardController@showsignuplist');
        Route::post('/signuplist', 'ProgrambuilderController@getSignupList');

        Route::post('/changepassword', 'AccountController@changePassword');
        Route::post('/changebilling', 'AccountController@changeBilling');
        Route::post('/changecontact', 'AccountController@changeContact');
        Route::post('/downgrade', 'AccountController@Downgrade');
        Route::get('/userdetail', 'AccountController@userdetailIndex');

        Route::post('/changebio', 'AccountController@changeBioInfo');
        Route::post('/changeprofilepic', 'AccountController@changeProfilePic');

        Route::post('/workoutdetail', 'ClientoverviewController@WorkoutDetail');
        Route::post('/nutritiondetail', 'ClientoverviewController@NutritionDetail');
        Route::post('/weekdetail', 'ClientoverviewController@WeekDetail');
        Route::post('/exercisedetail', 'ClientoverviewController@ExerciseDetail');

        Route::group(['prefix' => 'clientoverview'], function () {
            Route::post('/', 'DashboardController@showclientoverview');
            Route::group(['prefix' => '/{userID}'], function () {
                Route::get('/', 'ClientoverviewController@showIndex');
                Route::post('/workout', 'ClientoverviewController@showWorkoutOverview');
                Route::post('/nutrition', 'ClientoverviewController@showNutritionOverview');
            });
        });

        Route::group(['prefix' => 'programbuilder'], function () {
            Route::get('/', 'ProgrambuilderController@ProgramBuilderIndex');
            Route::get('/{programtype}', 'ProgrambuilderController@NewProgramIndex');
            Route::post('/{programtype}', 'ProgrambuilderController@CreateProgram');

            Route::group(['middleware' => 'PTProgram'], function()
            {
                Route::get('/{programtype}/edit', 'ProgrambuilderController@ViewProgram');

                Route::group(['prefix' => '/{programtype}/{userid}/{programid}'], function () {
                    Route::get('/', 'ProgrambuilderController@EditProgram');
                    Route::post('/', 'ProgrambuilderController@UpdateProgram');
                    Route::get('/edit', 'ProgrambuilderController@EditIndex');
                    Route::get('/view', 'ProgrambuilderController@ViewProgramDetailIndex');
                    Route::post('/finish', 'ProgrambuilderController@FinishProgramBuildIndex');
                    Route::post('/publish', 'ProgrambuilderController@PublishProgram');
                    Route::post('/delete', 'ProgrambuilderController@DeleteProgram');
                    Route::get('/data', 'WorkoutController@getWorkouts');
                    Route::post('/data', 'WorkoutController@addWorkout');
                    Route::post('/savesetinfo', 'WorkoutController@saveSetContent');
                    Route::post('/savedoc', 'WorkoutController@saveDocContent');
                    Route::delete('/data', 'WorkoutController@deleteWorkout');
                    Route::put('/data', 'WorkoutController@updateWorkout');
                });
            });
        });
    });
});
