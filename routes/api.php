<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/





// II. Admin endpoint .

//show All Cities for testing purpose
//Route::get('cities','CitiesController@ShowAllCities');

// Add New City .
Route::post('cities','CitiesController@AddCity');

//show All the delivery times just for testing
//Route::get('delivery-times','Delivery_times@showAll');

//Add New Delivery time
Route::post('delivery-times','Delivery_times@AddDeliveryTime');

////Attaching cities to delivery times
Route::post('/cities/{cities}/delivery_time','CitiesController@AttachingToDelivery');



// Excluding deliver times for some dates
Route::post('/excluding/{cities}/{date}/','Delivery_times@excludeDelivery');

// III. User EndPoints.
Route::get('cities/{city}/delivery-dates-times/{datetime}','CitiesController@UserEndpoint');



