<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'location' => 'required|min:3|max:255',
            'availabilityFrom' => 'nullable|date_format:d/m/Y',
            'availabilityTo' => 'nullable|date_format:d/m/Y',
            'sleeps' => 'nullable|integer|min:1',
            'beds' => 'nullable|integer|min:1'
        ];
    }
}
