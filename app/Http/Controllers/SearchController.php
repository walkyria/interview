<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Services\SearchService;
use Illuminate\Support\Carbon;

class SearchController extends Controller
{
    /** @var SearchService */
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchForm()
    {
        return view('pages.search');
    }

    /**
     * @param SearchRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function search(SearchRequest $request)
    {
        if (
            $request->filled('availabilityFrom') &&
            Carbon::createFromFormat('d/m/Y', $request->get('availabilityFrom')) < Carbon::now()) {
            return redirect('search-form')->withErrors('Invalid Availability From date');
        }

        if ($request->filled('availabilityTo') &&
            Carbon::createFromFormat('d/m/Y', $request->get('availabilityTo')) < Carbon::now()) {
            return redirect('search-form')->withErrors('Invalid Availability To date');
        }

        $result = null;
        if ($request->filled('location')) {
            $result = $this->searchService->findProperties($request->all());
        }

        return view('pages.search', [
            'result' => $result,
            'filter' => $request->all()
        ]);
    }
}
