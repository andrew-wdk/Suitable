<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnavailableRequest extends FormRequest
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

    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         'difference' => strtotime($this->end) - strtotime($this->start)
    //     ]);
    // }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start' => 'required|date_format:Y-m-d H:i:s',
            'end' => 'required|date_format:Y-m-d H:i:s|after:start',
            'priority' => 'required|numeric',
            //'difference' =>'min:1'
        ];
    }
}
