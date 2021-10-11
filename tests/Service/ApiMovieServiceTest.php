<?php

namespace App\Tests\Service;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\ApiMovieService;

class ApiMovieServiceTest extends KernelTestCase
{
    private $apiMovieService;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->apiMovieService = $container->get(ApiMovieService::class);
    }

    public function testGetListGenders(): void
    {
        $genderObject = $this->apiMovieService->getListGenders();
        $this->assertIsObject($genderObject);

    }

    public function testGetListBestMovies(): int
    {
        list($listResult, $url) = $this->apiMovieService->getListBestMovies([]);
        $this->assertIsObject($listResult);
        $this->assertIsString($url);
        $this->assertStringContainsString('www.themoviedb.org/t/p/w185_and_h278_bestv2',$url);
        $this->assertObjectHasAttribute("results", $listResult);
        list($oneResult) = $listResult->results;

        return $oneResult->id;

    }

    /**
     * @depends testGetListBestMovies
     */
    public function testGetMovieDetails($id): void
    {
        list($listResult, $url) = $this->apiMovieService->getMovieDetails($id);
        $this->assertIsObject($listResult);
        $this->assertIsString($url);
        $this->assertStringContainsString('www.themoviedb.org/t/p/w300',$url);
        $this->assertObjectHasAttribute("original_title", $listResult);

    }

    /**
     * @depends testGetListBestMovies
     */
    public function testGetMovieVideo($id): void
    {
        $result = $this->apiMovieService->getMovieVideo($id);
        $this->assertIsString($result);

    }
}
