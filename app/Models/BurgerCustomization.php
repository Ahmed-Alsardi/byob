<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BurgerCustomization extends Model
{
    use HasFactory;

    protected $fillable = [
        "category",
        "name",
    ];

    public static function getAll(): Collection
    {
        return BurgerCustomization::all();
    }
}
