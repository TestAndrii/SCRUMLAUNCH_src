<?php

namespace App\Providers;

use App\Events\EventTest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            $query->sql; // выполненная sql-строка
            $query->bindings; // параметры, переданные в запрос (то, что подменяет '?' в sql-строке)
            $query->time; // время выполнения запроса

            $location = collect(debug_backtrace())->filter(function ($trace) {
                return !str_contains($trace['file'], 'vendor/');
            })->first(); // берем первый элемент не из каталога вендора

            $bindings = implode(", ", $query->bindings); // форматируем привязку как строку

            $message = "
           ------------
           Sql: $query->sql
           Bindings: $bindings
           Time: $query->time
           File: ${location['file']}
           Line: ${location['line']}
           ------------
            ";
            Log::info($message);

            if (!str_contains($query->sql, 'jobs')){
//                var_dump($query->sql);
                # Запуск события
            event(new EventTest($message));
            }

//            var_dump($location, $bindings);
        });
    }
}
