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
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i:s',
            'location' => 'nullable|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'category_id' => 'required|exists:categories,id'
        ];
    }
}
