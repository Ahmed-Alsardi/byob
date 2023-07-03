<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    use HasFactory;

    protected $fillable = [
        "meat_id",
        "bread_id",
        "sides",
        "order_id",
    ];

    protected $casts = [
        "sides" => "array",
    ];

    public function sides() {
        return json_decode($this->sides, true);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
