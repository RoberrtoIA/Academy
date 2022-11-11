<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use App\Models\Program;
use App\Services\ProgramService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramResource;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;

class ProgramController extends Controller
{
    protected ?User $user;

    public function __construct(protected ProgramService $programService)
    {
        $this->user = request()->user();
    }

    public function index()
    {
        $programs = Program::query();

        if ($this->user->tokenCan('add_program_content')) {
            $programs = $this->user->myProgramsAsDeveloper()
                ->with('modules.evaluation_criteria')
                ->with('modules.topics.questions');
        }

        return ProgramResource::collection($programs->get());
    }

    public function store(StoreProgramRequest $request)
    {
        $attributes = $request->validated();

        return new ProgramResource($this->programService->createProgram($attributes)->load('tags'));
    }

    public function show(Program $program)
    {
        if ($this->user->tokenCan('add_program_content')) {
            $program->developers()->findOrFail($this->user->id);
        }

        if (
            $this->user->tokenCan('add_program_content')
            or $this->user->tokenCan('add_program_content')
        ) {
            $program->load('developers');
        }

        return new ProgramResource($program->load(['tags', 'modules.topics']));
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
