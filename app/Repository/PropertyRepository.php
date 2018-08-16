<?php
declare(strict_types=1);

namespace App\Repository;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class PropertyRepository
{
    protected $databaseManager;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * @param string $location
     * @param Carbon $availabilityFrom
     * @param Carbon $availabilityTo
     * @param int $sleeps
     * @param int $beds
     * @param bool $acceptsPets
     * @param bool $nearBeach
     * @return Collection|null
     */
    public function findByCriteria(
        string $location,
        Carbon $availabilityFrom,
        Carbon $availabilityTo,
        int $sleeps = 1,
        int $beds = 1,
        bool $acceptsPets = false,
        bool $nearBeach = false
    ): ? Collection {
        return $this->databaseManager->table('properties as p')
            ->join('locations as l', 'l.__pk', '=', 'p._fk_location')
            ->where('l.location_name', 'LIKE', $location)
            ->where('p.accepts_pets', '=', $acceptsPets)
            ->where('p.near_beach', '=', $nearBeach)
            ->where('p.sleeps', '>=', $sleeps)
            ->where('p.beds', '>=', $beds)
            ->whereNotIn('p.__pk', function (Builder $subQuery) use ($availabilityFrom, $availabilityTo) {
                $subQuery->select('__pk')
                    ->from('bookings as b')
                    ->where(function (Builder $subQuery) use ($availabilityFrom, $availabilityTo) {
                        $subQuery->where('b.start_date', '>=', $availabilityFrom)
                            ->where('b.start_date', '<=', $availabilityTo);
                    })
                    ->orWhere(function (Builder $subQuery) use ($availabilityFrom, $availabilityTo) {
                        $subQuery->where('b.end_date', '>=', $availabilityFrom)
                            ->where('b.end_date', '<=', $availabilityTo);
                    });
            })
            ->get();
    }
}
