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
//验证码
Route::get('/verify',                   'HomeController@verify');
//登陆模块
Route::group(['namespace'  => "Auth"], function () {
    Route::get('/login',                'LoginController@showLoginForm')->name('login');
    Route::post('/login',               'LoginController@login');
    Route::get('/logout',               'LoginController@logout')->name('logout');
});
//后台主要模块
Route::group(['middleware' => ['auth', 'permission']], function () {
    Route::get('/admin',                     'HomeController@index');
    Route::get('/gewt',                 'HomeController@configr');
    Route::get('/welcome',                'HomeController@welcome');
    Route::post('/getInfo',             'HomeController@getInfo');
    Route::post('/sort',                'HomeController@changeSort');
    Route::resource('/menus',           'MenuController');
    Route::resource('/logs',            'LogController');
    Route::resource('/users',           'UserController');
    Route::get('/userinfo',             'UserController@userInfo');
    Route::post('/saveinfo/{type}',     'UserController@saveInfo');
    Route::resource('/roles',           'RoleController');
    Route::resource('/permissions',     'PermissionController');
    Route::resource('/types',           'TypesController');
    Route::post('/types/{id}/edit',        'TypesController@edit');
    Route::get('/types/{id}',        'TypesController@destroy');
    Route::post('/saveEdit/{type}',           'TypesController@saveEdit');
    Route::resource('/games',     'GamesController');
    Route::resource('/orders',     'OrdersController');
    Route::resource('/site',     'SitesController');
});
//前台首页
Route::get('/',                   'IndexController@index');
Route::get('/index',                   'IndexController@index');
Route::get('/home/edit',                   'IndexController@edit');
Route::get('/home/checkorder',                   'IndexController@checkorder');
Route::get('/home/confirm',                   'IndexController@confirmOrder');
Route::post('/home/confirm',                   'IndexController@confirm');

