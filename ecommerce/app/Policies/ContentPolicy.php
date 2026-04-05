<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;

class ContentPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function update(User $user, Content $content)
    {
        return $content->author_id === $user->id;
    }

    public function delete(User $user, Content $content)
    {
        return $content->author_id === $user->id;
    }
}
