<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
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
