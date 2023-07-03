<?php

namespace App\Repository;

use App\Models\BurgerCustomization;
use Illuminate\Database\Eloquent\Collection;

class BurgerCustomizationRepository
{

    public static function getId(string $category, string $name): int
    {
        return BurgerCustomization::query()
            ->where("category", $category)
            ->where("name", $name)
            ->first()
            ->id;
    }
    public static function getBreads(): Collection|array
    {
        return self::_getType("bread");
    }

    public static function getMeats(): Collection|array
    {
        return self::_getType("meat");
    }

    public static function getSides(): Collection|array
    {
        return self::_getType("side");
    }

    public static function addBread(string $bread): void
    {
        self::_addToCategory("bread", $bread);
    }

    public static function addMeat(string $meat): void
    {
        self::_addToCategory("meat", $meat);
    }

    public static function addSide(string $side): void
    {
        self::_addToCategory("side", $side);
    }

    private static function _addToCategory(string $category, string $value): void
    {
        BurgerCustomization::query()
            ->create([
                "category" => $category,
                "name" => $value,
            ]);
    }

    private static function _getType(string $category): Collection|array
    {
        return BurgerCustomization::query()
            ->where("category", $category)
            ->get();
    }
}
