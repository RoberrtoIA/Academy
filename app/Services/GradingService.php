<?php

namespace App\Services;

use App\Factories\GradingResourceFactory;
use App\Http\Resources\GradingResource;
use App\Models\Grading;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class GradingService
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

    public function upsert(FormRequest $request, string $gradableType)
    {
        $attributes = $request->validated();

        Validator::make($attributes, [
            'gradables.*.gradable_id' => '|exists:' . $gradableType . ',id'
        ])->validate();

        foreach ($attributes['gradables'] as $gradable) {
            $grading = Grading::updateOrCreate(
                ['gradable_id' => $gradable['gradable_id'], 'gradable_type' => $gradableType],
                ['comments' => $gradable['comments'], 'grade' => $gradable['grade']]
            );

            if (!$grading->snapshot) {
                $this->takeSnapshot(
                    $grading,
                    $gradableType::find($request->input('gradable_id')),
                    $gradableType
                );
            }
        }

        return $grading;
    }
}
