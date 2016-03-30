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

Route::get('laravel', function () {
    return view('welcome');
});
Route::get('incompatible', function () {
    return view('mobile.incompatible');
});
Route::get('home', ['as' => 'home', 'uses' => 'BlogController@index']);
Route::get('/', ['as' => 'index', 'uses' => 'BlogController@index']);

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::resource('blog', 'BlogController', [
    'except' => [
        'vote'
    ]
]);
Route::post('/blog/{id}/vote', [
        'as' => 'blog.vote',
        'uses' => 'BlogController@vote',
    ]);

Route::resource('reply', 'ReplyController', [
    'only' => [
        'store', 'destroy'
    ]
]);
Route::post('/reply/{id}/vote', [
        'as' => 'reply.vote',
        'uses' => 'ReplyController@vote',
    ]);
Route::resource('user', 'Generic\UserController', [
    'only' => [
        'show', 'edit', 'update'
    ]
]);
Route::resource('notification', 'NotificationController', [
    'only' => [
        'show', 'destroy'
    ]
]);
Route::get('/notification/count', [
    'as' => 'notification.count',
    'uses' => 'NotificationController@count'
]);
Route::post('upload-image-clip', [
    'as' => 'upload_image_clip',
    'uses' => 'Generic\ImageController@uploadImageAndClip'
]);