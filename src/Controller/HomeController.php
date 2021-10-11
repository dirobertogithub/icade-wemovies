<?php

namespace App\Controller;

use App\Service\ApiMovieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'list_movies')]
    public function listMovies(ApiMovieService $apiMovieService, Request $request): Response
    {

        $genderIds = $request->request->get('genders',[]);
        $listGenders = $apiMovieService->getListGenders();
        list($listMovies, $urlCover) = $apiMovieService->getListBestMovies($genderIds);

        if(count($listMovies->results) > 0 ){
            list($firstMovie) = $listMovies->results;
            $videoToPlay = $apiMovieService->getMovieVideo($firstMovie->id);
        }else{
            $listMovies = null;
            $videoToPlay = null;
        }

        return $this->render('home/index.html.twig', [
            'listGenders' => $listGenders,
            'videoToPlay' => $videoToPlay,
            'listMovies' => $listMovies,
            'urlCover' => $urlCover,
            'gendersChecked' => $genderIds,
            'listToDisplay' => true
        ]);
    }

    #[Route('/details/{movieId}', name:'detail_movie')]
    public function detailMovie(ApiMovieService $apiMovieService, $movieId): Response
    {
        list($movie, $urlImage) = $apiMovieService->getMovieDetails($movieId);

        $videoToPlay = $apiMovieService->getMovieVideo($movieId);

        return $this->render('home/details-movie.html.twig',[
            'detailsMovie' => $movie,
            'detailsVideo' => $videoToPlay,
            'urlImage' => $urlImage
        ]);
    }

    #[Route('/autocomplete/{keyUp}', name:'autocomplete')]
    public function autocompleteMovie(ApiMovieService $apiMovieService, $keyUp): Response
    {
        $listMovies = $apiMovieService->getAutocomplete($keyUp);

        return $this->render('home/autocomplete-movie.html.twig',[
            'listMovies' => $listMovies
        ]);
    }

    #[Route('/search/{movieId}', name:'search_movie')]
    public function searchMovie(ApiMovieService $apiMovieService, $movieId): Response
    {
        $genderIds = [];
        $listGenders = $apiMovieService->getListGenders();
        list($movie, $urlImage) = $apiMovieService->getMovieDetails($movieId);

        $videoToPlay = $apiMovieService->getMovieVideo($movieId);


        return $this->render('home/index.html.twig', [
            'listGenders' => $listGenders,
            'videoToPlay' => $videoToPlay,
            'listMovies' => $movie,
            'listToDisplay' => false,
            'gendersChecked' => $genderIds
        ]);
    }



}
