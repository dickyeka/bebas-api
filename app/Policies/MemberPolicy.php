<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Member $member)
    {
        return $member->user_id == $user->id;
    }

    public function delete(User $user, Member $member)
    {
        return $member->user_id === $user->id;
    }
}
