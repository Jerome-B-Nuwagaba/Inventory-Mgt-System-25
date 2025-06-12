<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Warehouse;

class WarehousePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Warehouse $warehouse): bool
    {
        return $user->id === $warehouse->manager_id || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Warehouse $warehouse): bool
    {
        return $user->id === $warehouse->manager_id || $user->isAdmin();
    }

    public function delete(User $user, Warehouse $warehouse): bool
    {
        return $user->isAdmin();
    }

    public function manage(User $user, Warehouse $warehouse): bool
    {
        return $user->id === $warehouse->manager_id || $user->isAdmin();
    }
} 