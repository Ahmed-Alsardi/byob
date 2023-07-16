<?php

namespace App\Repository;

use App\Models\Burger;

class BurgerRepository
{

    const BURGER_SESSION_NAME = "burgers";

    public static function createBurgers(array $burgers, int $order_id = null): void
    {
        if ($order_id){
            self::_insertBurger($burgers, $order_id);
        } else {
            if (session()->exists(self::BURGER_SESSION_NAME)) {
                session()->remove(self::BURGER_SESSION_NAME);
            }
            session([self::BURGER_SESSION_NAME => $burgers]);
        }
    }

    public static function convertBurgerToReadableIngredient(Burger $burger): array
    {
        $meat = BurgerCustomizationRepository::getName("meat", $burger->meat_id);
        $bread = BurgerCustomizationRepository::getName("bread", $burger->bread_id);
        $sides = [];
        if ($burger->sides()) {
            foreach ($burger->sides() as $side) {
                $sides[] = BurgerCustomizationRepository::getName("side", $side);
            }
        }
        return [
            "meat" => $meat,
            "bread" => $bread,
            "sides" => $sides,
        ];
    }

    private static function _insertBurger(array $burgers, int $order_id): void
    {
        $burgerList = [];
        foreach ($burgers as $b) {
            $burgerList[] = self::_buildBurger($b);
        }
        foreach ($burgerList as $b ) {
            Burger::insertBurger($b, $order_id);
        }
    }

    private static function _buildBurger($b) {
        $meat_id = BurgerCustomizationRepository::getId("meat", $b['meat']);
        $bread_id = BurgerCustomizationRepository::getId("bread", $b['bread']);
        $sides = [];
        if (isset($b["sides"])) {
            foreach ($b['sides'] as $side) {
                $sides[] = BurgerCustomizationRepository::getId("side", $side);
            }
        }
        return [
            "meat_id" => $meat_id,
            "bread_id" => $bread_id,
            "sides" => $sides,
        ];
    }

}
