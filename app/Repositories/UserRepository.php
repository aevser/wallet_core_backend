<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function __construct(private User $user){}

    public function findById(int $id): User
    {
        return $this->user->query()->findOrFail($id);
    }
}
