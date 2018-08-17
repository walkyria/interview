<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
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
        $response = $this->post('/search', $data);
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testValidatesDateInPast()
    {
        $data = [
            'location' => 'anything',
            'availabilityFrom' => '01/01/2017',
            'availabilityTo' => '07/01/2017'
        ];

        $response = $this->post('/search', $data);
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
            '_fk_location'  => $location->__pk,
            'property_name' => 'test property name'
        ]);

        $this->assertDatabaseHas('locations', ['__pk' => $location->__pk]);
        $this->assertDatabaseHas('properties', ['__pk' => $property->__pk]);

        $data = [
            'location' => $location->location_name
        ];

        $response = $this->actingAs($user)->post('/search', $data);
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
            '_fk_location'  => $location->__pk,
            'property_name' => 'test property name'
        ]);

        $this->assertDatabaseHas('locations', ['__pk' => $location->__pk]);
        $this->assertDatabaseHas('properties', ['__pk' => $property->__pk]);

        $data = [
            'location'         => $location->location_name,
            'availabilityFrom' => '20/07/2018',
            'availabilityTo'   => '28/07/2018'
        ];
        $response = $this->actingAs($user)->post('/search', $data);
        $response->assertDontSee('test property name');

        $dateFrom = Carbon::now()->addDays(2)->format('d/m/Y');
        $dateTo = Carbon::now()->addDays(9)->format('d/m/Y');

        $this->assertDatabaseMissing('bookings', [
            'availabilityFrom' => $dateFrom,
            'availabilityTo'   => $dateTo
        ]);

        $data = [
            'location'         => $location->location_name,
            'availabilityFrom' => $dateFrom,
            'availabilityTo'   => $dateTo
        ];

        $response = $this->actingAs($user)->post('/search', $data);
        $response->assertSee('test property name');
    }

    public function testPaginatedResults()
    {
        $user = factory(User::class)->create();
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

        $response = $this->actingAs($user)->post('/search', $data);
        $response->assertSee('pagination');
        $response->assertSee('page-link');
    }
}
