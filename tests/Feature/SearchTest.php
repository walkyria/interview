<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group search
     */
    public function testReturnAvailablePropertyForLocation()
    {
        $user = factory(User::class)->create();

        $location = factory(Location::class)->create(['location_name' => 'location test']);
        $property = factory(Property::class)->create(['_fk_location' => $location->__pk]);

        $this->assertDatabaseHas('locations', ['__pk' => $location->__pk]);
        $this->assertDatabaseHas('properties', ['__pk' => $property->__pk]);

        $data = [
            'location' => $location->location_name
        ];

        $response = $this->actingAs($user)->post('/search', $data);
        $response->assertSee('location test');
    }

    /**
     * @group search
     */
    public function testReturnsAvailablePropertyForLocationAndDatesInTheFuture()
    {
        $user = factory(User::class)->create();
        $location = factory(Location::class)->create(['location_name' => 'location test']);
        $property = factory(Property::class)->create(['_fk_location' => $location->__pk]);

        $this->assertDatabaseHas('locations', ['__pk' => $location->__pk]);
        $this->assertDatabaseHas('properties', ['__pk' => $property->__pk]);

        $data = [
            'location' => $location->location_name,
            'availabilityFrom' => '20/07/2018',
            'availabilityTo' => '28/07/2018'
        ];
        $response = $this->actingAs($user)->post('/search', $data);
        $response->assertDontSee('location test');

        $data = [
            'location' => $location->location_name,
            'availabilityFrom' => Carbon::now()->addDays(2)->format('d/m/Y'),
            'availabilityTo' => Carbon::now()->addDays(9)->format('d/m/Y')
        ];
        $response = $this->actingAs($user)->post('/search', $data);
        $response->assertSee('location test');
    }
}
