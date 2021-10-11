<?php

namespace App\Service;

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

Class ApiMovieService
{
    private $httpClient;
    private $apiMoviesParams;

    public function __construct(HttpClientInterface $httpClient, $tmdbParams)
    {
        $this->httpClient = $httpClient;
        $this->apiMoviesParams = $tmdbParams;
    }

    public function getListGenders() : object
    {

        return $this->callApi($this->apiMoviesParams['url_api']['list_genders']);
    }

    public function getListBestMovies($genderIds) : array
    {
        /** get the list of the best movies, list order by vote average (desc) to make the first the best of the best */
        $url = $this->apiMoviesParams['url_api']['list_movies_discover'];
        if(count($genderIds)>0)
            $genderIds = implode(',',$genderIds);

        $paramsDiscover  = [
            'sort_by'               => 'vote_average.desc',
            'vote_count.gte'        => 50,
            'with_genres'           => $genderIds
        ];

         $listBestMovies = $this->callApi($url,$paramsDiscover);

        return [
            $listBestMovies,
            $this->apiMoviesParams['image_url'].$this->apiMoviesParams['list']
        ];
    }


    public function getMovieDetails($movieId): array
    {
        $urlMovie = str_replace('[movie_id]', $movieId, $this->apiMoviesParams['url_api']['detail_movies']);

        return  [
            $this->callApi($urlMovie),
            $this->apiMoviesParams['image_url'].$this->apiMoviesParams['modal']
        ];

    }


    public function getMovieVideo($movieId): ?string
    {
        $urlMovieVideo  = str_replace('[movie_id]', $movieId, $this->apiMoviesParams['video_url']);
        $videoUrl = null;
        $videos = $this->callApi($urlMovieVideo);

        if(isset($videos) && count($videos->results) >0 )  {

            list($video) = $videos->results;
            $playUrl    = $this->apiMoviesParams['play_video_url'];
            $key = '?key=';
            if($video->site === 'YouTube'){
                $playUrl    = $this->apiMoviesParams['youtube_embed_url'];
                $key = '/';
            }
            $videoUrl = $playUrl.$key.$video->key;
        }

        return  $videoUrl;
    }

    public function getAutocomplete($key): object
    {
        $url = $this->apiMoviesParams['url_api']['search_movie'];
        $paramsSearch  = [
            'page'                  => 1,
            'include_adult'         => false,
            'query'                 => $key
        ];

        return  $this->callApi($url,$paramsSearch);

    }


    private function callApi($url, $params=[])
    {
        try {
            $response = $this->httpClient->request(
                "GET",
                $this->apiMoviesParams['url_api']['base'].$url,
                ['query'=> array_merge($params, [
                                'api_key' => $this->apiMoviesParams['key']
                       ])
                ]
            );
            return json_decode($response->getContent());

        } catch (\Throwable $exception) {
            error_log('Error: '.$exception->getMessage());
        }

    }
}
