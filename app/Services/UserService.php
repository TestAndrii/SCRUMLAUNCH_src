<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UserService
{

    /**
     * @param $user_id
     * @return mixed
     */
    public function search($user_id): mixed
    {
        $user = User::find($user_id);
        if (!$user) {
            Log::debug('UserNotFoundException: User not found by ID ' . $user_id);
            throw new ModelNotFoundException('User not found by ID ' . $user_id);
        }
        return $user;
    }

}
