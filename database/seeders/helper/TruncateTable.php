<?php

namespace Database\Seeders\helper;

use Illuminate\Support\Facades\DB;

trait TruncateTable
{

    public function truncateTable(string $table): void
    {
        DB::table($table)->truncate();
    }
}
