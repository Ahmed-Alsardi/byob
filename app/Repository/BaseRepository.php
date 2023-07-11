<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class BaseRepository
{

    public static function updateByKeyValue($table, $key, $value, array $data): int
    {
        return DB::table($table)->where($key, $value)->update($data);
    }

    public static function create($table, array $data): int
    {
        return DB::table($table)->insert($data);
    }

}
