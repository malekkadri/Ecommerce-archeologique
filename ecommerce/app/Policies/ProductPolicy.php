<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function update(User $user, Product $product)
    {
        return $user->vendorProfile && $product->vendor_profile_id === $user->vendorProfile->id;
    }

    public function delete(User $user, Product $product)
    {
        return $this->update($user, $product);
    }
}
