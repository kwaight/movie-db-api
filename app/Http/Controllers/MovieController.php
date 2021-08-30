<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieQuery;
use App\Services\MovieDbService;
use GuzzleHttp\Exception\GuzzleException;

class MovieController extends Controller
{
    /**
     * Query a movie
     * @param MovieQuery $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function query(MovieQuery $request): \Illuminate\Http\JsonResponse
    {
        $apiKey = config('services.movie-db.key');
        $baseUri = config('services.movie-db.base-uri');
        $imageBaseUrl = config('services.movie-db.image-base-url');
        $linkUrl = config('services.movie-db.link-url');

        $movieService = new MovieDbService($apiKey, $baseUri);

        try {
            $results = $movieService->query(
                $request->only(['sort', 'order', 'page'])
            );
        } catch (GuzzleException $exception) {
            return response()
                ->json(['message' => 'Invalid query'], 400);
        }

        $data = collect($results->results)->map(function($record) use ($imageBaseUrl, $linkUrl) {
            return [
                'id' => $record->id,
                'title' => $record->title,
                'release_date' => $record->release_date,
                'popularity' => $record->popularity,
                'image' => $record->poster_path ? $imageBaseUrl . $record->poster_path : '',
                'link' => $linkUrl . $record->id
            ];
        });

        $response = [
            'total_pages' => $results->total_pages,
            'page' => $results->page,
            'data' => $data
        ];

        return response()
            ->json($response);
    }
}
