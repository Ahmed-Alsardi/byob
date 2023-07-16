<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Auth\Access\Response;

class LocationPolicy
{
    public function create(?User $user) {
        return $this->onlyCustomerOrGuest($user);
    }

    public function store(?User $user) {
        return $this->onlyCustomerOrGuest($user);
    }

    private function isUserCustomer(User $user): bool
    {
        return $user->role == UserRepository::CUSTOMER;
    }

    /**
     * @param User|null $user
     * @return Response
     */
    private function onlyCustomerOrGuest(?User $user): Response
    {
        if (!$user) {
            return Response::allow();
        }
        if (self::isUserCustomer($user)) {
            return Response::allow();
        }
        return Response::deny('You are not allowed to perform this action as you are not a customer');
    }
}
