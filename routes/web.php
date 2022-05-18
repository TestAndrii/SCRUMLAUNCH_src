<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/emailTest', function (){
    $time =  now()->addMinute(10);

    \Illuminate\Support\Facades\Mail::to('fav1@i.ua')
        ->later($time, new \App\Mail\MailTest($time));
//        ->queue(new \App\Mail\MailTest($time));

    return 'Email send Successfuly!!! - '.$time;
});
