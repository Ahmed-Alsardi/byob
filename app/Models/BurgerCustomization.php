<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BurgerCustomization extends Model
{
    use HasFactory;

    protected $fillable = [
        "category",
        "name",
    ];

    public function scopeBread($query)
    {
        return $query->where("category", "bread");
    }

    public function scopeMeat($query)
    {
        return $query->where("category", "meat");
    }

    public function scopeSide($query)
    {
        return $query->where("category", "side");
    }
}
