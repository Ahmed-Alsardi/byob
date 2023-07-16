<?php

namespace App\Policies;

use App\Models\Chef;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Auth\Access\Response;

class ChefPolicy
{

    public function viewList(User $user): bool
    {
        return $this->adminUser($user);
    }
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Chef $chef): bool
    {
        return $this->adminUser($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->adminUser($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Chef $chef): bool
    {
        return $this->adminUser($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Chef $chef): bool
    {
        return $this->adminUser($user);
    }

    public function updateAvailable(User $user): bool
    {
        if ($user->role === UserRepository::CHEF) {
            return true;
        }
        return false;
    }

    private function isUserAdmin(User $user)
    {
        return $user->role === UserRepository::ADMIN;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function adminUser(User $user): bool
    {
        if ($this->isUserAdmin($user)) {
            return true;
        }
        return false;
    }

}
