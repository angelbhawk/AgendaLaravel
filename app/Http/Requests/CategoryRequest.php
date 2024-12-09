<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Asegúrate de aplicar middlewares de autenticación
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255'
        ];
    }
}
