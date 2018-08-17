<?php

namespace Tests\Unit;

use App\Repository\PropertyRepository;
use App\Services\SearchService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class SearchServiceTest extends TestCase
{
    private $propertyRepository;

    private $lengthAwarePaginator;

    public function setUp()
    {
        parent::setUp();

        $this->propertyRepository = $this->prophesize(PropertyRepository::class);
        $this->lengthAwarePaginator = $this->prophesize(LengthAwarePaginator::class);
    }

    public function testReceivesLengthAwarePaginator()
    {
        $location = 'anything';

        $this->propertyRepository->findByCriteria(Argument::cetera())
            ->shouldBeCalled()
            ->willReturn($this->lengthAwarePaginator->reveal());

        $searchService = new SearchService($this->propertyRepository->reveal());
        $searchService->findProperties([
            'location' => $location
        ]);
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->prophesize()->checkProphecyMethodsPredictions();
    }
}
