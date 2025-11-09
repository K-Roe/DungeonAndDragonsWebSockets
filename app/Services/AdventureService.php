<?php

namespace App\Services;

use App\Entities\Adventure;
use App\Entities\Assessment;
use App\Entities\AssessmentAdvice;
use App\Entities\FinancialAssessment;
use App\Entities\MultiAssessmentAdvice;
use App\Entities\User;
use App\Enums\PlusOrMinusEnum;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdventureService
{
    private mixed $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Persists and flushes the given data entity to the database.
     *
     * @param mixed $data The data entity to be saved.
     * @return void
     */
    public function save(mixed $data): void
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();

    }

    /**
     * @param $data
     * @return int
     */
    public function saveNewAdventure($data): int
    {
        $User = auth()->user();

        $adventure = new Adventure(
            $User,
            $data['title'],
            $data['description'],
            $data['maxPlayers'],
            $data['isPrivate'],
            true
        );

        $this->save($adventure);

        return $adventure->getId();

    }

    public function activeAdventures(): array
    {

        $user = auth()->user();
        return $this->entityManager->getRepository(Adventure::class)->findBy(['user' => $user]);

    }

//    /**
//     * @param $data
//     * @param $name
//     * @return array
//     */
//    public function getAdvise($data, $name): array
//    {
//        $laravelUser = auth()->user();
//        $userId = $laravelUser->getAuthIdentifier();
//
//        $user = $this->entityManager->getRepository(User::class)->find($userId);
//
//        $assessment = $this->entityManager->getRepository(Assessment::class)
//            ->findOneBy(['name' => $name, 'user' => $user]);
//
//        $prompt = "You are MerlinAI, a friendly AI financial advisor.
//Introduce yourself once at the start only. The user is from the United Kingdom.
//Analyze this spending data and suggest ways the user could improve their finances: "
//            . json_encode($data) .
//            " Break your advice into clear, friendly paragraphs.
//Use line breaks between tips and bold or headings where appropriate.
//Respond fully in one message, suitable for displaying directly on a web page.";
//
//        $apiKey = config('services.gemini.api_key');
//
//        $response = Http::withHeaders([
//            'Content-Type' => 'application/json',
//            'X-Goog-Api-Key' => $apiKey,
//        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
//            'contents' => [
//                [
//                    'parts' => [
//                        ['text' => $prompt]
//                    ]
//                ]
//            ]
//        ]);
//
//        $responseData = $response->json();
//        $aiText = trim($responseData['candidates'][0]['content']['parts'][0]['text'] ?? 'No advice available.');
//
//        // Split into chat-friendly lines
//        $lines = preg_split('/\r?\n\r?/', $aiText);
//        $messages = [];
//        foreach ($lines as $line) {
//            $line = trim($line);
//            if ($line !== '') {
//                $messages[] = ['role' => 'assistant', 'content' => $line];
//            }
//        }
//
//        // Save the full advice as one string
//        if (!empty($aiText) && $aiText !== 'No advice available.') {
//            $advice = new AssessmentAdvice(
//                $user,
//                $assessment,
//                $aiText
//            );
//            $this->save($advice);
//        }
//
//        return $messages;
//    }



}
