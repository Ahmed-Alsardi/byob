<?php

namespace App\Policies;

use App\Helper\UserRole;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ComplaintPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role  !== UserRole::CHEF;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Complaint $complaint): bool
    {
        return $this->sameUserOrAdmin($user, $complaint);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::CUSTOMER;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Complaint $complaint): bool
    {
        return $user->role === UserRole::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Complaint $complaint): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Complaint $complaint): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Complaint $complaint): bool
    {
        //
    }

    /**
     * @param User $user
     * @param Complaint $complaint
     * @return bool
     */
    public function sameUserOrAdmin(User $user, Complaint $complaint): bool
    {
        if ($user->role === UserRole::ADMIN || $user->id == $complaint->order->customer_id) {
            return true;
        }
        return false;
    }
}
