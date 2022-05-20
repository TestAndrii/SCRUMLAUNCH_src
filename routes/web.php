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
    $ts = microtime(true);

    // Delay for send eMail
    $emailJob = (new \App\Jobs\SendEmailJob())->delay(now()->addSeconds(5));
    dispatch($emailJob);

    // Send eMail now.
    \Illuminate\Support\Facades\Mail::to('user@test.domain')->send(new \App\Mail\MailTest('Now'));
    // put eMail to Queue
    \Illuminate\Support\Facades\Mail::to('user@test.domain')->queue(new \App\Mail\MailTest('Queue'));

    $spent = microtime(true) - $ts;
    // Job processing time
    echo 'All eMail sent. Time spent ' . sprintf('%.4f sec', $spent);
});
