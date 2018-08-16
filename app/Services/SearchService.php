<?php
declare(strict_types=1);

namespace App\Services;

use App\Repository\PropertyRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class SearchService
{
    /** @var PropertyRepository */
    protected $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function findProperties(array $params): ? Collection {
        $location = $params['location'];
        $availabilityFrom = Carbon::now()->addDays(1);
        if($params['availabilityFrom'] && Carbon::createFromFormat('d/m/Y', $params['availabilityFrom']) >= Carbon::now()) {
            $availabilityFrom = Carbon::createFromFormat('d/m/Y', $params['availabilityFrom']);
        }
        $availabilityTo = Carbon::now()->addDays(1);
        if($params['availabilityTo'] && Carbon::createFromFormat('d/m/Y', $params['availabilityTo']) >= Carbon::now()) {
            $availabilityTo = Carbon::createFromFormat('d/m/Y', $params['availabilityTo']);
        }
        $sleeps = $params['sleeps'] ?? 1;
        $beds = $params['beds'] ?? 1;
        $acceptsPets = $params['acceptsPets'] ?? false;
        $nearBeach = $params['nearBeach'] ?? false;

        return $this->propertyRepository->findByCriteria(
            $location,
            $availabilityFrom,
            $availabilityTo,
            $sleeps,
            $beds,
            $acceptsPets,
            $nearBeach
        );
    }
}
