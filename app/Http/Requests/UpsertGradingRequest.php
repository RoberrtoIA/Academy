<?php

namespace App\Http\Requests;

use App\Models\EvaluationCriteria;
use App\Models\Grading;
use App\Models\Question;
use Illuminate\Contracts\Validation\Validator;
// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpsertGradingRequest extends FormRequest
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
        $PolymorphExistsRule = '';
        if ($this->has('gradable_type') && $this->has('gradable_id')) {
            $PolymorphExistsRule .= '|exists:' . $this->gradable_type . ',id';
        }

        return [
            'comments' => 'required|string',
            'grade' => 'required|string',
            'gradable_type' => 'required|required_with:gradable_id',
            'gradable_id' => 'required|required_with:gradable_type' . $PolymorphExistsRule,
        ];

        // if (request('gradable_type')::find(request('gradable_id'))->getRelated() == Question::getRelated()) {
        //     return [
        //         'field1' => 'required',
        //         'field2' => 'required',
        //     ];
        // }

        // return [
        //     'gradable_id' => Rule::exists('questions')->where(function ($query) {
        //         return $query->where('id', request('gradable_id'));
        //     }),
        //     // 'gradable_id'
        //     // 'gradable_type' =>
        //     'comments' => 'required|string|max:200',
        //     'grade' => 'required|string',
        //     'snapshot' => 'required|string',
        // ];
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'errors' => $validator->errors(),
    //         'status' => true
    //     ], 422));
    // }
}
