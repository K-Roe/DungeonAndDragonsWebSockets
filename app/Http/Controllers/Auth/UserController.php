<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Responses\user\UserResponse;

class UserController
{

    public function getUser()
    {
        $user = auth()->user();

        return UserResponse::one($user);
    }
}
