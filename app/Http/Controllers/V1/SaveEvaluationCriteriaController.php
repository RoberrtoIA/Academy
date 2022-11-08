<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpsertGradingRequest;
use App\Http\Resources\GradingResource;
use App\Models\EvaluationCriteria;
use App\Services\GradingService;

class SaveEvaluationCriteriaController extends Controller
{
    public function __invoke(UpsertGradingRequest $request, GradingService $service)
    {
        return new GradingResource(
            $service->upsert($request, EvaluationCriteria::class)->load('gradable')
        );
    }
}
