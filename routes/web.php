<?php

use App\Jobs\SendEmailJob;
use App\Mail\MailTest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TelegramNotification;

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
    $emailJob = (new SendEmailJob())->delay(now()->addSeconds(5));
    dispatch($emailJob);

    // Send eMail now.
    Mail::to('user@test.domain')->send(new MailTest('Now'));
    // put eMail to Queue
    Mail::to('user@test.domain')->queue(new MailTest('Queue'));

    $spent = microtime(true) - $ts;
    // Job processing time
    echo 'All eMail sent. Time spent ' . sprintf('%.4f sec', $spent);
});

Route::get('/NotificationLaravelBoot', function ()
{
    $notifiable = config('services.telegram-bot-api.bot_id');
    Notification::send($notifiable,new TelegramNotification('Notification message - '.now()) );

});
