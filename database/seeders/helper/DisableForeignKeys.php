<?php

namespace Database\Seeders\helper;

use Illuminate\Support\Facades\DB;

trait DisableForeignKeys
{

    public function disableForeignKeys(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
    }

    public function enableForeignKeys(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
