<?php

namespace App\Services;

use App\Factories\GradingResourceFactory;
use App\Models\Grading;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class GradingSnapshotService
{
    public function __construct(protected GradingResourceFactory $resourceFactory)
    {
    }

    public function takeSnapshot(Grading $grading, Model $gradable, string $gradableType): Grading
    {
        $grading->snapshot = $this->resourceFactory->make($gradable, $gradableType)->resolve();
        $grading->save();

        return $grading;
    }
}
