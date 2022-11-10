<?php

namespace App\Http\Controllers\V1;

use App\Models\Program;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramResource;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\ProgramService;

class ProgramController extends Controller
{

    public function __construct(protected ProgramService $programService,)
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

        return new ProgramResource($this->programService->createProgram($attributes)->load('tags'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Program $program)
    {
        return new ProgramResource($program->load(['tags', 'modules']));
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

        $program = $this->programService->updateProgram($program, $attributes);

        return new ProgramResource($program->load('tags'));
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
