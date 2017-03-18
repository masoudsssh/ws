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

use Illuminate\Support\Facades\Redis;

Route::get('/', function () {
	// Redis::set('name','masoud');
	// Cache::put('name1','masoud1', 30);
 	// return Cache::get('name1'); 
    
    return view('welcome');

	// $data = [
	// 	'event'=>'paymentRequest',
	// 	'data'=>[
	// 		'user_id'=>12,
	// 		'status'=>'initiate'
	// 	]
	// ];
	// Redis::publish('kiple-channel', json_encode($data));
});

Route::get('/publish', function () {
	$data = [
		'event'=>'UserSignedUp',
		'data'=>[
			'user_id'=>12,
			'username'=>'masoud',
			'status'=>'initiate',
			"socketid"=> Request::query('id')
		]
	];
	Redis::publish('kiple-channel', json_encode($data));
	return 'ok';
});
