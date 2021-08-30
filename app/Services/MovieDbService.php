<?php
namespace App\Services;

use GuzzleHttp\Client;

/**
 * Class MovieDbService
 * @package App\Services
 */
class MovieDbService {
    /**
     * @var string $apiKey
     */
    private $apiKey;

    /**
     * @var string $baseUri
     */
    private $baseUri = 'https://api.themoviedb.org/3/';

    /**
     * @var \GuzzleHttp\Client client
     */
    private $client;

    /**
     * Available endpoints
     */
    const ENDPOINTS = [
        'discover' => 'discover/movie'
    ];

    /**
     * Available genres list
     */
    const GENRES = [
        'action' => 28
    ];

    /**
     * MovieDbService constructor.
     * @param string $apiKey
     * @param null $baseUri
     */
    public function __construct(string $apiKey, $baseUri = null)
    {
        $this->apiKey = $apiKey;
        if ($baseUri) {
            $this->baseUri = $baseUri;
        }

        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'timeout'  => 2.0,
        ]);
    }

    /**
     * Movie query
     * @param array $parameters
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function query($parameters = [])
    {
        $query = [
            'api_key' => $this->apiKey,
            'primary_release_date.gte' => '2010-01-01',
            'primary_release_date.lte' => '2012-12-31',
            'page' => $parameters['page'] ?? 1,
            'sort_by' => ($parameters['sort'] ?? 'title') . '.' . ($parameters['order'] ?? 'asc'),
            'with_genres' => self::GENRES['action']
        ];

        $response = $this->client->request('GET', self::ENDPOINTS['discover'], [
            'query' => $query
        ]);

        return json_decode($response->getBody()->getContents());
    }
}
