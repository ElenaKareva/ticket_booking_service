<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class TicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'film_title' =>['required', 'string', 'min:3', 'max:255'], 
            'hall_name' => ['required', 'string', 'min:1', 'max:10'], 
            'session_start' => ['required', 'string'],  
            'session_date' => ['required', 'string'],
            'places' => ['required', 'string'], 
            'priceSum' =>['required', 'integer'],
        ];
    }
}