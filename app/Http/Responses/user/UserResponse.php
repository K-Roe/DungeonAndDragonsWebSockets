<?php

namespace App\Http\Responses\user;

use App\Entities\Adventure;
use App\Entities\User;

class UserResponse
{
    /**
     * Transform a single Assessment entity into an array.
     */
    public static function one(User $user): array
    {
        return [
            'id'    => $user->getId(),
            'name'  => $user->getName(),
            'email' => $user->getEmail(),

        ];
    }

    /**
     * Transform multiple Assessment entities into an array of arrays.
     */
    public static function many(array $values): array
    {
        return [
            'users' => array_map(fn(User $v) => self::one($v), $values),
        ];
    }
}
