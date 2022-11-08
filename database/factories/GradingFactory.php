<?php

namespace Database\Factories;

use App\Models\EvaluationCriteria;
use App\Models\Grading;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grading>
 */
class GradingFactory extends Factory
{

    protected $model = Grading::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'comments' => fake()->text($maxNbChars = 20),
            'grade' => fake()->sentence(),
        ];
    }

}
