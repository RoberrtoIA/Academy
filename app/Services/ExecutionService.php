<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Execution;
use Illuminate\Foundation\Http\FormRequest;

class ExecutionService
{
    public function createExecution(FormRequest $request): Execution
    {
        $data = $request->validated();

        return Execution::create($data);
    }
}
