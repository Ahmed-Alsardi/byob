<?php

namespace App\Repository;

use App\Models\BurgerCustomization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class BurgerCustomizationRepository
{

    const MEAT = "meat";
    const BREAD = "bread";
    const SIDE = "side";

    const CUSTOMIZATION_CACHE_NAME = "customizations";

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
        return self::_getType(self::BREAD);
    }

    public static function getMeats(): Collection|array
    {
        return self::_getType(self::MEAT);
    }

    public static function getSides(): Collection|array
    {
        return self::_getType(self::SIDE);
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

    public static function getAllCustomization()
    {
        return Cache::rememberForever(self::CUSTOMIZATION_CACHE_NAME, fn() => BurgerCustomization::getAll());
    }

    public static function addCustomization(mixed $category, mixed $name)
    {
        self::_addToCategory($category, $name);
    }
}
