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

    public static function getId(string $category, string $name)
    {
        return BurgerCustomization::getCustomizationId($category, $name);
    }

    public static function getName(string $category, int $id)
    {
        return BurgerCustomization::getCustomizationName($category, $id);
    }

    public static function getAllCustomization()
    {
        return Cache::rememberForever(self::CUSTOMIZATION_CACHE_NAME, fn() => BurgerCustomization::getAll());
    }

    public static function addCustomization($category, $name)
    {
        BurgerCustomization::insertCustomization($category, $name);
        Cache::forget(self::CUSTOMIZATION_CACHE_NAME);
    }
}
