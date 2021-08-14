<?php

namespace App\Policies;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatingPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Rating $rating): bool
    {
        return $user->id == $rating->user_id;
    }
}
