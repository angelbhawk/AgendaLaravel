<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'nullable|string',
            'time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'priority' => 'required',
            'category_id' => 'nullable'
        ];
    }
}
