<?php

namespace App\Schedules;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class DailyDbImport
{
    public function __invoke()
    {
        Artisan::call('db:wipe');
        $sql = file_get_contents(storage_path('app/db/db_import.sql'));
        DB::unprepared($sql);
        Artisan::call('optimize:clear');
    }
}
