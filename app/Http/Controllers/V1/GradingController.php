<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\GradingResource;
use App\Models\Grading;

class GradingController extends Controller
{

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
