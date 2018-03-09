<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'v1'], function($router) {
    $router->get('bosbisuser', 'RoutesController@index');

});


$router->group(['prefix' => 'v1/bis-trip'], function($router) {
    $router->get('bosbisuser', 'RoutesController@index');

    $router->get('bosbisuser/{id}', 'BosbisUserController@getBosbisUser');

    $router->get('routeCityFrom', 'RoutesController@getCitiesFrom');

    $router->get('routeCityTo/{cityCode}', 'RoutesController@getCitiesTo');

    $router->get('routeOperator/{cityCodeFrom}/{cityCodeTo}', 'RoutesController@getRoutesOperators');

});

$router->group(['prefix' => 'v1/bis-schedule'], function($router) {

    $router->get('schedules/{cityFrom}/{cityTo}/{dateTrip}/{fromRow}/{limitRow}', 'ScheduleController@getScheduleController');

    $router->get('schedules/{cityFrom}/{cityTo}/{dateTrip}', 'ScheduleController@getScheduleControllerPlain');

    $router->get('schedulesDetail/{routeId}/{dateTrip}', 'ScheduleController@getScheduleControllerByRoute');

});

$router->group(['prefix' => 'v1/bis-transaction'], function($router)
{
    $router->post('booking','TransactionController@postOrderController');
    $router->post('confirm','TransactionController@postOrderConfirmController');

});

$router->group(['prefix' => 'v1/bis-seat'], function($router)
{
    $router->get('getSeatSold/{tripId}/{tripDate}/{cityFrom}/{cityTo}','SeatController@getSeatSold');
    $router->get('getSeatBooked/{tripId}/{tripDate}/{cityFrom}/{cityTo}','SeatController@getSeatBooked');

});
