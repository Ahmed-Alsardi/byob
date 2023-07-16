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

    public static function insertCustomization($category, $value)
    {
        return self::query()
            ->insert([
                "category" => $category,
                "name" => $value
            ]);
    }

    public static function getCustomizationId($category, $value)
    {
        return self::query()
            ->where("category", $category)
            ->where("name", $value)
            ->first()
            ?->id;
    }

    public static function getCustomizationName($category, $id)
    {
        return self::query()
            ->where("category", $category)
            ->where("id", $id)
            ->first()
            ?->name;
    }
}
