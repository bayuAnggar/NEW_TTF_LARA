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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('refresh', 'AuthController@refresh');

    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');

    });
});

Route::group(['middleware' => 'auth:api'], function(){
    // Users
    Route::get('users', 'UserController@index')->middleware('isAdmin');
    Route::get('user/{id}', 'UserController@show')->middleware('isAdminOrSelf');

    //list TTF
    //Route::post('ttf', 'ViewTTFController@index');
    Route::post('ttf', 'ViewTTFController@show');
    Route::post('genttf', 'GeneratePDF@ttf');

    //list BPB
    Route::post('branchlist', 'BranchListController@show');

    //detail_supplier
    Route::post('site_detail', 'BranchListController@addr_detail_supp');

    //bpb_per_supplier
    Route::post('bpb_supplier', 'BpbSiteDataController@get_data_bpb');

});
