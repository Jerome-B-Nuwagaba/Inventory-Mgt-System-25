<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->buyer_id || $user->id === $order->seller_id;
    }

    public function create(User $user): bool
    {
        return $user->isRetailer() || $user->isManufacturer();
    }

    public function update(User $user, Order $order): bool
    {
        return $user->id === $order->seller_id;
    }

    public function delete(User $user, Order $order): bool
    {
        return $user->isAdmin();
    }
} 