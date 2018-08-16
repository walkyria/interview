<?php

namespace Tests\Integration;

use App\Models\Location;
use App\Models\Property;
use App\Services\SearchService;
use Tests\TestCase;

class SearchServiceTest extends TestCase
{
    public function testReturnAvailablePropertyForLocation()
    {
        $location = factory(Location::class)->create(['location_name' => 'location test']);
        $property = factory(Property::class)->create(['_fk_location' => $location->__pk]);

        $this->assertDatabaseHas('locations', ['__pk' => $location->__pk]);
        $this->assertDatabaseHas('properties', ['__pk' => $property->__pk]);

        $this->getSut()->findProperties([
                'location' => $location->location_name
            ])->willReturn($property);


    }

    public function testReturnAvailablePropertyForLocationAndDatesInTheFuture()
    {
        $location = factory(Location::class)->create(['location_name' => 'location test']);
        $property = factory(Property::class)->create(['_fk_location' => $location->__pk]);

        $this->assertDatabaseHas('locations', ['__pk' => $location->__pk]);
        $this->assertDatabaseHas('properties', ['__pk' => $property->__pk]);

        $this->getSut()->findProperties([
            'location' => $location->location_name,
            'availabilityFrom' => '2018-07-20',
            'availabilityTo' => '2018-07-28'
        ])->shouldNotReturn($property);
    }

    private function getSut()
    {
        return $this->createMock(SearchService::class);
    }
}
