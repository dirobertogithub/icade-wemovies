<?php

namespace App\Tests\Controller;

use App\Service\ApiMovieService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testListMovies(): void
    {
        $client = static::createClient();
        $container = static::getContainer();
        $crawler = $client->request('GET', '/');
        $apiMovieService = $container->get(ApiMovieService::class);
        $listGenders = $apiMovieService->getListGenders();
        list($listMovies, $urlCover) = $apiMovieService->getListBestMovies([]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertIsObject($listGenders);
        $this->assertIsObject($listMovies);
        $this->assertIsString($urlCover);


    }
}
