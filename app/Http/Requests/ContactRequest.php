<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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

        // I think what I need here is to include the 'error messages' in case of failure?

        return [
            'name' => 'required',
            'email' => 'required|email',
            'company',
            'phone',
            'enquiry' => 'required',
            'g-recaptcha-response' => 'recaptcha|required',
        ];
    }
}
