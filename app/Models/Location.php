<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        "city",
        "street",
        "house_number",
        "user_id",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
