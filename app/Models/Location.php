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

    public static function getLocationByCustomerId($userId)
    {
        return Location::query()
            ->where("user_id", $userId)
            ->first()
            ->get();
    }

    public static function createCustomerLocation($userId, array $location)
    {
        return self::query()
            ->create([
                "city" => $location["city"],
                "street" => $location["street"],
                "house_number" => $location["house_number"],
                "user_id" => $userId,
            ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
