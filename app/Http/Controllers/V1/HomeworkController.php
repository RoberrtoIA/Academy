<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHomeworkRequest;
use App\Http\Requests\UpdateHomeworkRequest;
use App\Http\Resources\HomeworkResource;
use App\Models\Homework;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return HomeworkResource::collection(Homework::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHomeworkRequest $request)
    {
        $attributes = $request->validated();

        $homework = Homework::create($attributes);

        return (new HomeworkResource($homework->load('module')))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Homework $homework)
    {
        return new HomeworkResource($homework->load('module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Homework $homework, UpdateHomeworkRequest $request)
    {
        $attributes = $request->validated();

        $homework->update($attributes);

        return new HomeworkResource($homework->load('module'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homework $homework)
    {
        $homework->delete();

        $response = [
            'message' => 'Topic Deleted'
        ];

        return response($response, 200);
    }
}
