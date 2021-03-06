<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login' ,['as' => 'login', 'uses' => 'AuthController@login']);
Route::post('/loginvalidate' ,['as' => 'loginvalidate', 'uses' => 'AuthController@loginvalidate']);
Route::resource('user','UserController',['only'=>['create','store']]);

Route::get('/select-acc',['middleware' => 'auth','as' => 'select-acc','uses'=>'UserController@selectacc']);
Route::post('/selected-acc',['middleware' => 'auth','as' => 'selected-acc','uses'=>'UserController@selectedacc']);
Route::get('/dashboard',['middleware' => 'auth', 'as'=>'dashboard','uses'=>'UserController@dashboard']);
Route::get('/logout',['as'=>'logout','uses'=>'AuthController@logout']);
Route::get('/dashboard/settings',['middleware' => 'auth', 'as'=>'settings','uses'=>'UserController@settings']);
Route::post('/dashboard/savesettings',['middleware' => 'auth', 'as' => 'savesettings','uses'=>'UserController@update']);
Route::post('/dashboard/changepassword',['middleware' => 'auth', 'as' => 'changepassword','uses'=>'UserController@changepassword']);
Route::get('/dashboard/spot-bills',['middleware' => 'auth', 'as' => 'spot-bills', 'uses' => 'DocController@spotbills']);
Route::post('/dashboard/getspotbills',['middleware' => 'auth','as' => 'getspotbills','uses'=>'DocController@getspotbills']);
Route::get('/dashboard/getspotbills',['middleware' => 'auth','as' => 'getspotbills', function(){
	return redirect()->route('spot-bills');
}]);
Route::get('/dashboard/money-receipts',['middleware'=>'auth','as'=>'moneyreceipt','uses'=>'DocController@moneyreceipt']);
Route::get('/dashboard/sap-bills',['middleware'=>'auth','as'=>'sap-bills','uses'=>'DocController@sapbills']);
Route::post('/dashboard/sap-bills',['middleware'=>'auth','as'=>'sap-bills','uses'=>'DocController@sapbills']);

Route::get('/dashboard/e-mobile-receipts',['middleware'=>'auth','as'=>'emobilereceipt','uses'=>'DocController@emobilereceipt']);
Route::post('/dashboard/getemobilereceipts',['middleware'=>'auth','as'=>'getemobilereceipt','uses'=>'DocController@getemobilereceipt']);
Route::get('/dashboard/getemobilereceipts',['middleware'=>'auth','as'=>'getemobilereceipt',function(){
	return redirect()->route('emobilereceipt');
}]);
Route::get('/dashboard/service-request',['middleware'=>'auth','as'=>'servicerequest','uses'=>'DocController@servicerequest']);
Route::get('/dashboard/feedbacks',['middleware'=>'auth','as'=>'feedbacks','uses'=>'DocController@feedbacks']);
Route::get('/dashboard/meter-protocol',['middleware'=>'auth','as'=>'meterprotocol','uses'=>'DocController@meterprotocol']);
Route::get('/dashboard/seal-replacement',['middleware'=>'auth','as'=>'sealreplacement','uses'=>'DocController@sealreplacement']);
Route::get('/dashboard/meter-change',['middleware'=>'auth','as'=>'meterchange','uses'=>'DocController@meterchange']);
Route::get('/dashboard/inspection-report',['middleware'=>'auth','as'=>'inspectionreport','uses'=>'DocController@inspectionreport']);
Route::get('/dashboard/provisional-ass',['middleware'=>'auth','as'=>'provisionalass','uses'=>'DocController@provisionalass']);
Route::get('/dashboard/final-ass',['middleware'=>'auth','as'=>'finalass','uses'=>'DocController@finalass']);
Route::post('/dashboard/addcontacc',['middleware' => 'auth','as' => 'addcontacc','uses'=>'UserController@addcontacc']);
Route::get('/dashboard/offline-docs',['middleware' => 'auth','as' => 'offlinedocs','uses'=>'DocController@offlinedocs']);
Route::get('/dashboard/disconnect-notice',['middleware' => 'auth','as' => 'disconnectnotice','uses' => 'DocController@disconnectnotice']);
Route::get('/dashboard/demand-note',['middleware' => 'auth', 'as' => 'demandnote','uses' => 'DocController@demandnote']);
Route::get('/dashboard/listspotbill',['middleware' => 'auth', 'as' => 'listspotbill','uses' => 'DocController@listspotbill']);
Route::get('/dashboard/listsapbill',['middleware' => 'auth', 'as' => 'listsapbill','uses' => 'DocController@listsapbill']);
Route::get('/dashboard/foc-slip',['middleware' => 'auth','as' => 'focslip','uses' => 'DocController@focslip']);


Route::group(['prefix'=>'api'],function(){
	Route::post('/login', ['uses'=>'ApiAuthController@apilogin']);
	Route::post('/register',['uses'=>'UserController@apiregister']);
	Route::post('/logout',['uses' => 'ApiAuthController@apilogout']);
	Route::get('/getuser',['uses' => 'ApiAuthController@apiauthenticatedUser']);
	Route::get('/gettoken',['uses' => 'ApiAuthController@getToken']);
	Route::get('/getstl',['uses' => 'ApiUserController@apistldata']);
	Route::get('/getsap',['uses' => 'ApiUserController@apisapdata']);
	Route::get('/savesettings',['uses' => 'ApiUserController@savesettings']);
	Route::get('/changepassword',['uses' => 'ApiUserController@changepassword']);
	Route::get('/apiemobilereceipt',['uses' => 'ApiDocController@apiemobilereceipt']);
	Route::get('/apimoneyreceipt',['uses' => 'ApiDocController@apimoneyreceipt']);
	Route::get('/getservicereq',['uses' => 'ApiDocController@getservicereq']);
	Route::get('/selectacc',['uses' => 'ApiAuthController@apiselectacc']);
	Route::get('/addcontacc',['uses' => 'ApiUserController@addcontacc']);
	Route::get('/spotbill',['uses' => 'ApiDocController@spotbill']);
	Route::get('/sapbill',['uses' => 'ApiDocController@sapbill']);
	Route::get('/servicereq',['uses' => 'ApiDocController@servicereq']);
	Route::get('/emobilereceipt',['uses' => 'ApiDocController@emobilereceipt']);
});


Route::get('/forgot',['as'=>'forgot','uses'=>'AuthController@forgot']);
Route::post('/handleforgot',['as'=>'handleforgot', 'uses' => 'AuthController@handleforgot']);

Route::any('/{page?}',function(){
  return View::make('errors.503');
})->where('page','.*');