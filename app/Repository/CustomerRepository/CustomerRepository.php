<?php

namespace App\Repository\CustomerRepository;

use App\Models\Customer;

class CustomerRepository
{

    public static function getByKeyValue(string $key, $value)
    {
        return Customer::query()
            ->where($key, $value)
            ->get();
    }

    public static function getCustomerById(mixed $userId)
    {
        return self::getByKeyValue("user_id", $userId);
    }
}
