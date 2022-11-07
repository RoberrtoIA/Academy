<?php

namespace App\Http\Controllers\V1;

use App\Models\Execution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExecutionResource;

class ExecutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ExecutionResource::collection(
            Execution::with('program')->paginate(100)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Execution  $execution
     * @return \Illuminate\Http\Response
     */
    public function show(Execution $execution)
    {
        return new ExecutionResource($execution->load('program.modules.topics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Execution  $execution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Execution $execution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Execution  $execution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Execution $execution)
    {
        //
    }
}
