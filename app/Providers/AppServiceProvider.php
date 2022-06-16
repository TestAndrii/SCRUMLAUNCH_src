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
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        DB::listen(function ($query) {
//            $query->sql; // выполненная sql-строка
//            $query->bindings; // параметры, переданные в запрос (то, что подменяет '?' в sql-строке)
//            $query->time; // время выполнения запроса

            $location = collect(debug_backtrace())->filter(function ($trace) {
                return !str_contains($trace['file'], 'vendor/');
            })->first(); // берем первый элемент не из каталога вендора
//            Sql: $query->sql

            $bindings = implode(", ", $query->bindings); // форматируем привязку как строку
            $message = "------------

               Bindings: $bindings
               Time: $query->time
               File: ${location['file']}
               Line: ${location['line']}
               ------------";

            $message = str_replace("`", "", $message);
//            Log::info($message);

            // Пропускаем запросы к очередям и задачам.
            if (!str_contains($query->sql, 'jobs')){
                # Запуск события
//                event(new EventTest($message));
            }
        });
    }
}
