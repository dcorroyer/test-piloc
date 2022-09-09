<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
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
            'wording' => 'required|max:100',
            'space' => 'required',
            'price' => 'required',
            //On peut ici ajouter la partie sur les status available or rented
            'status' => 'required',
        ];
    }
}
