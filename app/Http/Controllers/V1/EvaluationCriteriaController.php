<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluationCriteriaRequest;
use App\Http\Requests\UpdateEvaluationCriteriaRequest;
use App\Http\Resources\EvaluationCriteriaResource;
use App\Models\EvaluationCriteria;
use Illuminate\Http\Request;

class EvaluationCriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EvaluationCriteriaResource::collection(EvaluationCriteria::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEvaluationCriteriaRequest $request)
    {
        $attributes = $request->validated();

        $evaluation = EvaluationCriteria::create($attributes);

        return (new EvaluationCriteriaResource($evaluation->load('module')))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(EvaluationCriteria $evaluation)
    {
        return new EvaluationCriteriaResource($evaluation->load('module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EvaluationCriteria $evaluation, UpdateEvaluationCriteriaRequest $request)
    {
        $attributes = $request->validated();

        $evaluation->update($attributes);

        return new EvaluationCriteriaResource($evaluation->load('module'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EvaluationCriteria $evaluation)
    {
        $evaluation->delete();

        $response = [
            'message' => 'Evaluation Criteria Deleted'
        ];

        return response($response, 200);
    }
}
