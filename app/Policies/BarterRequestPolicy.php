<?php

namespace App\Policies;

use App\Models\BarterRequest;
use App\Models\User;

class BarterRequestPolicy
{
    public function delete(User $user, BarterRequest $barterRequest): bool
    {
        return $user->id === $barterRequest->user_id;
    }
}
