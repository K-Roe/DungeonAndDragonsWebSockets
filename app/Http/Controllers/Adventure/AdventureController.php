<?php

namespace App\Http\Controllers\Adventure;

use App\Events\AdventureMessage;
use App\Http\Responses\game\AdventureResponse;
use App\Services\AdventureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdventureController
{

    /**
     * @param Request $request
     * @param AdventureService $adventureService
     * @return JsonResponse
     */
    public function store(Request $request, AdventureService $adventureService)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'maxPlayers' => 'integer|min:2|max:8',
            'isPrivate' => 'boolean',
        ]);

        $adventure = $adventureService->saveNewAdventure($data);

        return response()->json(['message' => 'Adventure created!', 'adventure' => $adventure]);
    }

    public function getActiveAdventures(AdventureService $adventureService)
    {
        $adventures = $adventureService->activeAdventures();
        return AdventureResponse::many($adventures);
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate(['text' => 'required|string|max:500']);

        broadcast(new AdventureMessage($request->user(), $request->text, (int)$id));

        return response()->json(['status' => 'ok']);
    }


}
