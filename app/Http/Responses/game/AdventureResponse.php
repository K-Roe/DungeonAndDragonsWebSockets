<?php

namespace App\Http\Responses\game;

use App\Entities\Adventure;

class AdventureResponse
{
    /**
     * Transform a single Assessment entity into an array.
     */
    public static function one(Adventure $adventure): array
    {
        return [
            'id' => $adventure->getId(),
            'title' => $adventure->getTitle(),
            'description' => $adventure->getDescription(),
            'isActive' => $adventure->getIsActive(),
            'maxPlayers' => $adventure->getMaxPlayers(),
            'currentPlayers' => 0,
        ];
    }

    /**
     * Transform multiple Assessment entities into an array of arrays.
     */
    public static function many(array $values): array
    {
        return [
            'adventures' => array_map(fn(Adventure $v) => self::one($v), $values),
        ];
    }
}
