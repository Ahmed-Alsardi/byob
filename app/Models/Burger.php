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

  public static function insertBurger(mixed $b, int $order_id)
  {
      self::query()->create([
          "meat_id" => $b["meat_id"],
          "bread_id" => $b["bread_id"],
          "sides" => json_encode($b["sides"] !== [] ? $b["sides"] : null),
          "order_id" => $order_id,
      ]);
  }

  public function sides() {
        return json_decode($this->sides, true);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
