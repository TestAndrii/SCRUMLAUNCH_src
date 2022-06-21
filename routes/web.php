<?php

use App\Jobs\SendEmailJob;
use App\Mail\MailTest;
use App\Events\EventTest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TelegramNotification;
use App\Http\Controllers\UserController;

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

// emailTest
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
    echo 'All eMail are sent to the queue. Time spent ' . sprintf('%.4f sec', $spent);
});

// NotificationLaravelBoot
Route::get('/NotificationLaravelBoot', function ()
{
    $ts = microtime(true);

    for ($i = 0; $i < 5; $i++){
        // Send message for Telegram
        Notification::send("Notification send message", new TelegramNotification('Notification message #'.$i.'- '.now()) );
    }

    $spent = microtime(true) - $ts;
    // Job processing time
    $notifiable = config('services.telegram-bot-api.bot_id');
    $message =  'All messages for Telegram are sent to the queue. Time spent ' . sprintf('%.4f sec', $spent);
    Notification::send($notifiable,new TelegramNotification($message) );
    echo $message;

});

// EventStart
Route::get('/EventStart',function (){
    $ts = microtime(true);

    # Запуск события
    event(new EventTest('Creating an event in a route.'));
//    \Illuminate\Support\Facades\Log::info('Test Event Logger.');


    // Job processing time
    $spent = microtime(true) - $ts;
    $message =  'Event sent to the queue. Time spent ' . sprintf('%.4f sec', $spent);
    echo "<br>".$message;
});

// Выборка из базы migration
Route::get('sql', function (){
    $migration = \Illuminate\Support\Facades\DB::table('migrations')->get();
});

// CustomException
Route::get('exception', function (){
    // something went wrong and you want to throw CustomException
    throw new \App\Exceptions\CustomException('Something Went Wrong.');
});

// ModelNotFoundException + Service = https://laravel.demiart.ru/isklyucheniya-laravel-lovim-obrabatyvaem-i-sozdaem-sobstvennye/
Route::get('ModelNotFoundException/users', [UserController::class, 'index'])->name('users.index');
Route::post('ModelNotFoundException/search',  [UserController::class, 'search'])->name('users.search');

// Logging -> Telegram = https://qna.habr.com/q/556303
Route::get('logging',function (){
    $message = 'An informational Logging message in Telegram chanel. ';
//    Log::emergency($message);
//    Log::alert($message);
//    Log::critical($message);
//    Log::error($message);
//      The channel telegram accepts messages higher than error.
//    Log::warning($message);
//    Log::notice($message);
//    Log::info($message);
//    Log::debug($message);

    // The channel telegram accepts messages higher than error.
    // This message will not go through
    Log::channel('telegram')->info('TELEGRAM. '. $message);
    // make Error in BD
    \Illuminate\Support\Facades\DB::table('users')->get('5');

});
