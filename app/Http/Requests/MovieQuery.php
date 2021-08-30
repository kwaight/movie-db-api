<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieQuery extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'sort' => 'sometimes|string|in:title,popularity,release_date',
            'order' => 'sometimes|string|in:asc,desc',
            'page' => 'sometimes|integer'
        ];
    }
}
