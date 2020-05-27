<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required',
            'duration' => 'required|numeric',
            'startDate' => 'required|date_format:Y-m-d H:i:s',
            'endDate' => 'required|date_format:Y-m-d H:i:s|after:startDate',
            'participants' => 'required'
        ];
    }
}
