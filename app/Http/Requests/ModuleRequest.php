<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

<<<<<<<< HEAD:app/Http/Requests/ModuleRequest.php
class ModuleRequest extends FormRequest
========
class StoreProgramRequest extends FormRequest
>>>>>>>> 0a925481b51cfebeb56a832de392919b4a9cc15c:app/Http/Requests/StoreProgramRequest.php
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:100',
            'description' => 'required|max:200',
            'content' => 'required|min:1',
        ];
    }
}
