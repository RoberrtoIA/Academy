<?php

namespace App\Http\Controllers\V1;

use App\Models\Program;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramResource;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Services\ProgramService;

class ProgramController extends Controller
{

    public function __construct(protected ProgramService $programService,)
    {
    }

    public function index()
    {
        // TODO  developer must see only its programs
        return ProgramResource::collection(Program::all());
    }

    public function store(StoreProgramRequest $request)
    {
        $attributes = $request->validated();

        return new ProgramResource($this->programService->createProgram($attributes)->load('tags'));
    }

    public function show(Program $program)
    {
        // TODO developer can see all developers
        return new ProgramResource($program->load(['tags', 'modules']));
    }

    public function update(Program $program, UpdateProgramRequest $request)
    {
        $attributes = $request->validated();

        $program = $this->programService->updateProgram($program, $attributes);

        return new ProgramResource($program->load('tags'));
    }

    public function destroy(Program $program)
    {
        $program->delete();

        $response = [
            'message' => 'Program Deleted'
        ];

        return response($response, 200);
    }
}
