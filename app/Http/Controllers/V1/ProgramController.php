<?php

namespace App\Http\Controllers\V1;

use App\Models\Program;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramResource;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\ProgramTagsService;
use App\Services\UpdateProgramService;

class ProgramController extends Controller
{

    public function __construct(
        protected ProgramTagsService $programTagsService,
        protected UpdateProgramService $updateProgramService
        )
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response(['data' => Program::paginate(5)], 200);
        return ProgramResource::collection(Program::all());
    }

    public function tag()
    {
        return TagResource::collection(Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgramRequest $request)
    {
        $attributes = $request->validated();

        return new ProgramResource($this->programTagsService->createProgram($attributes));
        // return $this->programTagsService->createProgram($attributes);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        return new ProgramResource($program);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Program $program, UpdateProgramRequest $request)
    {
        $attributes = $request->validated();

        $program->update($attributes);

        $program = $this->updateProgramService->updateProgram($program, $attributes);

        return new ProgramResource($program);
        // return $this->updateProgramService->updateProgram($program, $attributes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        $program->delete();

        $response = [
            'message' => 'Program Deleted'
        ];

        return response($response, 200);
    }
}
