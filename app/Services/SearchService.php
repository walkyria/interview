<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\PropertyRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class SearchService
{
    /** @var PropertyRepository */
    protected $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * This assumes location will always be provided.
     * if Availability is not provided it will select properties that do not have
     * bookings for the next 7 days
     * If AcceptsPets is false then it will return properties that accepts and do not accept pets
     * If NearBeach is false it will return all properties near, or not, to the beach
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function findProperties(array $params): LengthAwarePaginator {
        $location = $params['location'];

        $availabilityFrom = Carbon::now()->addDays(1);
        if(isset($params['availabilityFrom']) && Carbon::createFromFormat('d/m/Y', $params['availabilityFrom']) >= Carbon::now()) {
            $availabilityFrom = Carbon::createFromFormat('d/m/Y', $params['availabilityFrom']);
        }

        $availabilityTo = Carbon::now()->addDays(8);
        if(isset($params['availabilityTo']) && Carbon::createFromFormat('d/m/Y', $params['availabilityTo']) >= Carbon::now()) {
            $availabilityTo = Carbon::createFromFormat('d/m/Y', $params['availabilityTo']);
        }
        $sleeps = $params['sleeps'] ?? 1;
        $beds = $params['beds'] ?? 1;
        $acceptsPets = $params['acceptsPets'] ?? false;
        $nearBeach = $params['nearBeach'] ?? false;
        $itemsPerPage = $params['itemsPerPage'] ?? 5;

        return $this->propertyRepository->findByCriteria(
            $location,
            $availabilityFrom,
            $availabilityTo,
            (int)$sleeps,
            (int)$beds,
            $acceptsPets,
            $nearBeach,
            $itemsPerPage
        );
    }
}
