<?php

namespace App\Http\Requests;

use App\Rules\ValidGermanZip;
use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
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
            'title' => 'required|string|min:5|max:50',
            'description' => 'required|string',
            'zip' => ['required', 'numeric', new ValidGermanZip],
            'city' => 'required|string',
            'deadline' => 'required|date_format:Y-m-d',
            'service_id' => 'required|integer|exists:services,id',
        ];
    }
}
