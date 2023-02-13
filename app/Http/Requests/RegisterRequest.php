<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
        ];
    }

    public function getData(): array
    {
        return [
            'username' => $this->get('username'),
            'phone_number' => $this->get('phone_number'),
        ];
    }
}
