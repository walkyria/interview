<?php

namespace Tests\Integration;

use App\Models\Location;
use App\Models\Property;
use App\Services\SearchService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @var SearchService */
    private $searchService;

    public function setUp()
    {
        parent::setUp();
        $this->searchService = app(SearchService::class);
    }

    /**
     * @group integration
     */
    public function testReturnPaginatedResults()
    {
        $location = factory(Location::class)->create(['location_name' => 'location test']);
        for ($i = 0; $i < 20; $i++) {
            factory(Property::class)->create([
                '_fk_location' => $location->__pk
            ]);
        }
        $data = [
            'location' => $location->location_name,
            'itemsPerPage' => 5
        ];

        $result = $this->searchService->findProperties($data);

        $this->assertEquals(5, count($result->items()));
        $this->assertEquals(20, $result->total());
    }
}
