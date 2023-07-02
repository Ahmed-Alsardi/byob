<?php

namespace App\Repository;

use App\Models\Side;
use Illuminate\Database\Eloquent\Collection;
class SideRepository
{

    public function getAll(): Collection
    {
        return Side::all();
    }
}
