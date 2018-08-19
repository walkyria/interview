<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Location;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function testSearchFormAccessibility()
    {
        $response = $this->get('/search-form');
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testSearchAccessibility()
    {
        $data = [
            'location' => 'anything'
        ];
        $response = $this->get(route('search', $data));
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testValidatesDateInPast()
    {
        $data = [
            'location' => 'anything',
            'availabilityFrom' => '01/01/2017',
            'availabilityTo' => '07/01/2017'
        ];

        $response = $this->get(route('search', $data));
        //dd($response);
        $response->assertRedirect('search-form');
        $response->assertSessionHasErrorsIn('default');
    }

    /**
     * @group search
     */
    public function testReturnAvailablePropertyForLocation()
    {
        $user = factory(User::class)->create();

        $location = factory(Location::class)->create(['location_name' => 'location test']);
        $property = factory(Property::class)->create([
            '_fk_location' => $location->__pk,
            'property_name' => 'test property name'
        ]);

        $this->assertDatabaseHas('locations', ['__pk' => $location->__pk]);
        $this->assertDatabaseHas('properties', ['__pk' => $property->__pk]);

        $data = [
            'location' => $location->location_name
        ];

        $response = $this->get(route('search', $data));
        $response->assertSee('test property name');
    }

    /**
     * @group searchFuture
     */
    public function testReturnsAvailablePropertyForLocationAndDatesInTheFuture()
    {
        $user = factory(User::class)->create();
        $location = factory(Location::class)->create(['location_name' => 'location test']);
        $property = factory(Property::class)->create([
            '_fk_location' => $location->__pk,
            'property_name' => 'test property name'
        ]);

        $this->assertDatabaseHas('locations', ['__pk' => $location->__pk]);
        $this->assertDatabaseHas('properties', ['__pk' => $property->__pk]);

        $data = [
            'location' => $location->location_name,
            'availabilityFrom' => '20/07/2018',
            'availabilityTo' => '28/07/2018'
        ];
        $response = $this->get(route('search', $data));
        $response->assertDontSee('test property name');

        $dateFrom = Carbon::now()->addDays(2)->format('d/m/Y');
        $dateTo = Carbon::now()->addDays(9)->format('d/m/Y');

        $this->assertDatabaseMissing('bookings', [
            'availabilityFrom' => $dateFrom,
            'availabilityTo' => $dateTo
        ]);

        $data = [
            'location' => $location->location_name,
            'availabilityFrom' => $dateFrom,
            'availabilityTo' => $dateTo
        ];

        $response = $this->get(route('search', $data));
        $response->assertSee('test property name');
    }

    public function testPaginatedResults()
    {
        $user = factory(User::class)->create();
        $location = factory(Location::class)->create(['location_name' => 'location test']);

        factory(Property::class)->create([
            '_fk_location' => $location->__pk
        ]);

        $data = [
            'location' => $location->location_name,
            'itemsPerPage' => 5
        ];

        $response = $this->get(route('search', $data));
        $response->assertDontSee('<ul class="pagination" role="navigation">');
        $response->assertDontSee('<li class="page-item">');

        for ($i = 0; $i < 20; $i++) {
            factory(Property::class)->create([
                '_fk_location' => $location->__pk
            ]);
        }

        $response = $this->get(route('search', $data));
        $response->assertSee('<ul class="pagination" role="navigation">');
        $response->assertSee('<li class="page-item">');
    }
    /**
     * @group search
     */
    public function testDoesNotReturnBookedPropertyForLocation()
    {
        $startDate = Carbon::now()->addDays(1);
        $endDate = Carbon::now()->addDays(8);
        $location = factory(Location::class)->create(['location_name' => 'location test']);
        $property = factory(Property::class)->create([
            '_fk_location' => $location->__pk,
            'property_name' => 'test property name'
        ]);

        factory(Booking::class)->create([
            '_fk_property' => $property->__pk,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        $this->assertDatabaseHas('locations', ['__pk' => $location->__pk]);
        $this->assertDatabaseHas('properties', ['__pk' => $property->__pk]);

        $data = [
            'location' => $location->location_name,
            'availabilityFrom' => $startDate->format('d/m/Y'),
            'availabilityTo' => $endDate->format('d/m/Y')
        ];

        $response = $this->get(route('search', $data));
        $response->assertDontSee('test property name');

        $startDate = Carbon::now()->addDays(10);
        $endDate = Carbon::now()->addDays(18);

        $data = [
            'location' => $location->location_name,
            'availabilityFrom' => $startDate->format('d/m/Y'),
            'availabilityTo' => $endDate->format('d/m/Y')
        ];

        $response = $this->get(route('search', $data));
        $response->assertSee('test property name');
    }
}
