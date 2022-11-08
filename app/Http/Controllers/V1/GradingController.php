<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertGradingRequest;
use App\Http\Resources\GradingResource;
use App\Models\EvaluationCriteria;
use App\Models\Grading;
use App\Models\Question;
use App\Services\GradingSnapshotService;
use Illuminate\Http\Request;

class GradingController extends Controller
{
    public function __construct(protected GradingSnapshotService $gradingSnapshotService)
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return GradingResource::collection(Grading::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upsert(UpsertGradingRequest $request)
    {
        $attributes = $request->validated();

        $grading = Grading::updateOrCreate(
            ['gradable_id' => $attributes['gradable_id'], 'gradable_type' => $attributes['gradable_type']],
            ['comments' => $attributes['comments'], 'grade' => $attributes['grade']]
        );

        if (!$grading->snapshot) {
            $this->gradingSnapshotService
                ->takeSnapshot(
                    $grading,
                    $request->input('gradable_type')::find($request->input('gradable_id')),
                    $request->input('gradable_type')
                );
        }

        return new GradingResource($grading->load('gradable'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Grading $grading)
    {
        return new GradingResource($grading->load('gradable'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grading $grading)
    {
        $grading->delete();

        $response = [
            'message' => 'Topic Deleted'
        ];

        return response($response, 200);
    }
}
