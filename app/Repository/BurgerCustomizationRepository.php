<?php

namespace App\Repository;

use App\Models\BurgerCustomization;
use Illuminate\Database\Eloquent\Collection;

class BurgerCustomizationRepository
{

    const MEAT = "meat";
    const BREAD = "bread";
    const SIDE = "side";

    const CACHE_NAME = "customizations";

    public static function getId(string $category, string $name): int
    {
        return BurgerCustomization::query()
            ->where("category", $category)
            ->where("name", $name)
            ->first()
            ->id;
    }

    public static function getName(string $category, int $id): string
    {
        return BurgerCustomization::query()
            ->where("category", $category)
            ->where("id", $id)
            ->first()
            ->name;
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

    public static function getCustomizations()
    {
        return BurgerCustomization::all();
    }

    public static function addCustomization(mixed $category, mixed $name)
    {
        self::_addToCategory($category, $name);
    }
}
