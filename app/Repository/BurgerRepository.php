<?php

namespace App\Repository;

use App\Models\Burger;

class BurgerRepository
{

    public static function createBurger(array $burgers, int $order_id = null): void
    {
        if ($order_id){
            self::_insertBurger($burgers, $order_id);
        } else {
            if (session()->exists("burgers")) {
                session()->remove("burgers");
            }
            session(["burgers" => $burgers]);
        }
    }

    private static function _insertBurger(array $burgers, int $order_id): void
    {
        $burgerList = [];
        foreach ($burgers as $b) {
            $meat_id = BurgerCustomizationRepository::getId("meat", $b['meat']);
            $bread_id = BurgerCustomizationRepository::getId("bread", $b['bread']);
            $sides = [];
            if (isset($b["sides"])) {
                foreach ($b['sides'] as $side) {
                    $sides[] = BurgerCustomizationRepository::getId("side", $side);
                }
            }
            $burgerList[] = [
                "meat_id" => $meat_id,
                "bread_id" => $bread_id,
                "sides" => $sides,
            ];
        }
        foreach ($burgerList as $b) {
            Burger::query()->create([
                "meat_id" => $b["meat_id"],
                "bread_id" => $b["bread_id"],
                "sides" => $b["sides"],
                "order_id" => $order_id,
            ]);
        }
    }

}
