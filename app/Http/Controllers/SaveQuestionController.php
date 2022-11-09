<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveGradableRequest;
use App\Http\Resources\GradingResource;
use App\Models\Question;
use App\Services\GradingService;

class SaveQuestionController extends Controller
{
    public function __invoke(SaveGradableRequest $request, GradingService $service)
    {
        return new GradingResource(
            $service->upsert($request, Question::class)->load('gradable')
        );
    }
}
