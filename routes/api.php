<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\TopicController;
use App\Http\Controllers\V1\ModuleController;
use App\Http\Controllers\V1\GradingController;
use App\Http\Controllers\V1\ProgramController;
use App\Http\Controllers\V1\QuestionController;
use App\Http\Controllers\SaveQuestionController;
use App\Http\Controllers\V1\ExecutionController;
use App\Http\Controllers\V1\EvaluationCriteriaController;
use App\Http\Controllers\V1\Execution\ExecutionAssignTrainerController;
use App\Http\Controllers\V1\SaveEvaluationCriteriaController;
use App\Http\Controllers\V1\Execution\FinishExecutionController;
use App\Http\Controllers\V1\User\CreateTraineeAccountController;
use App\Http\Controllers\V1\User\CreateEmployeeAccountController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::name('api.v1.')->prefix('v1')->group(function () {

    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::get('/programs/tags', [ProgramController::class, 'tag'])
            ->middleware(['ability:manage_programs']);

        Route::resource('programs', ProgramController::class)
            ->only(['store', 'update', 'destroy'])
            ->middleware(['ability:manage_programs']);

        Route::resource('programs', ProgramController::class)
            ->only(['index', 'show'])
            ->middleware([
                'ability:manage_programs'
                    . ',see_program_content_details'
                    . ',see_program_content'
            ]);

        Route::resource('modules', ModuleController::class)
            ->only(['store', 'update', 'destroy'])
            ->middleware(['ability:manage_modules']);

        Route::resource('modules', ModuleController::class)
            ->only(['index', 'show'])
            ->middleware([
                'ability:manage_modules'
                    . ',see_module_content_details'
                    . ',see_module_content'
            ]);

        Route::resource('topics', TopicController::class)
            ->except(['index', 'show'])
            ->middleware(['ability:manage_topics']);

        Route::resource('topics', TopicController::class)
            ->only(['index', 'show'])
            ->middleware([
                'ability:manage_topics'
                    . ',see_topic_content_details'
                    . ',see_topic_content'
            ]);

        Route::resource('questions', QuestionController::class)
            ->except(['index', 'show'])
            ->middleware(['ability:manage_questions']);

        Route::resource('questions', QuestionController::class)
            ->only(['index', 'show'])
            ->middleware([
                'ability:manage_questions'
                    . ',see_question_content_details'
                    . ',see_question_content'
            ]);

        Route::resource('evaluations', EvaluationCriteriaController::class)
            ->except(['index', 'show'])
            ->middleware(['ability:manage_evaluation_criterias']);

        Route::resource('evaluations', EvaluationCriteriaController::class)
            ->only(['index', 'show'])
            ->middleware([
                'ability:manage_evaluation_criterias'
                    . ',see_evaluation_criteria_content_details'
                    . ',see_evaluation_criteria_content'
            ]);

        Route::put('save-evaluation-criteria', SaveEvaluationCriteriaController::class)
            ->middleware(['ability:take_homework'])->name('save-evaluation-criteria');

        Route::put('save-question', SaveQuestionController::class)
            ->middleware(['ability:take_quiz'])->name('save-question');

        Route::resource('gradings', GradingController::class)
            ->only(['destroy'])
            ->middleware(['ability:manage_gradings']);

        Route::resource('gradings', GradingController::class)
            ->only(['index', 'show'])
            ->middleware([
                'ability:manage_gradings'
                    . ',see_grading_content_details'
                    . ',see_grading_content'
            ]);

        Route::post('users/create-trainee-account', CreateTraineeAccountController::class)
            ->name('users.createTraineeAccount')
            ->middleware(['ability:manage_user_accounts']);

        Route::post('users/create-employee-account', CreateEmployeeAccountController::class)
            ->name('users.createEmployeeAccount')
            ->middleware(['ability:manage_user_accounts']);


        Route::resource('users', UserController::class)
            ->only(['index', 'show', 'update', 'destroy'])
            ->middleware(['ability:manage_user_accounts']);

        Route::resource('executions', ExecutionController::class)
            ->only(['index', 'show'])
            ->middleware([
                'ability:manage_executions'
                    . ',see_program_content_details'
                    . ',see_program_content'
            ]);

        Route::resource('executions', ExecutionController::class)
            ->only(['store', 'update', 'destroy'])
            ->middleware(['ability:manage_executions']);

        Route::get('executions/finish/{execution}', FinishExecutionController::class)
            ->name('executions.finish')
            ->middleware(['ability:manage_executions']);

        Route::get(
            'executions/{execution}/assign-trainer/{trainer}',
            ExecutionAssignTrainerController::class
        )
            ->name('executions.assign-trainer')
            ->middleware(['ability:manage_user_accounts']);
    });
});
