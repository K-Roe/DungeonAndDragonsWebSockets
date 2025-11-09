<?php

use Illuminate\Support\Facades\Broadcast;



Broadcast::channel('adventure.{id}', function ($user, $id) {
    // Authorize if the user can join this adventure
    return true; // or add logic: $user->adventures->contains($id)
});
