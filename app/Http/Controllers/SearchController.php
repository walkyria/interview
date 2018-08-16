<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        if (
            $request->filled('availabilityFrom') &&
            Carbon::createFromFormat('d/m/Y', $request->get('availabilityFrom')) < Carbon::now()) {
            return redirect('search')->withErrors('Invalid Availability From date');
        }

        if ($request->filled('availabilityTo') &&
            Carbon::createFromFormat('d/m/Y', $request->get('availabilityTo')) < Carbon::now()) {
            return redirect('search')->withErrors('Invalid Availability To date');
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'location' => 'required|string|max:255',
            'sleeps' => 'nullable|integer',
            'beds' => 'nullable|integer',
            'availabilityFrom' => 'nullable|date_format:d/m/Y',
            'availabilityTo' => 'nullable|date_format:d/m/Y'
        ];
    }
}
