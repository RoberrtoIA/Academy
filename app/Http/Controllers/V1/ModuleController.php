<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use App\Http\Resources\ModuleResource;
use App\Models\Module;

class ModuleController extends Controller
{
    public function index()
    {
        return ModuleResource::collection(Module::all());
    }

    public function store(StoreModuleRequest $request)
    {
        $attributes = $request->validated();

        $module = Module::create($attributes);

        return (new ModuleResource($module->load('program')))->response()->setStatusCode(201);
    }

    public function show(Module $module)
    {
        return new ModuleResource($module->load(['topics', 'program']));
    }

    public function update(Module $module, UpdateModuleRequest $request)
    {
        $attributes = $request->validated();

        $module->update($attributes);

        return new ModuleResource($module->load('program'));
    }

    public function destroy(Module $module)
    {
        $module->delete();

        $response = [
            'message' => 'Module Deleted'
        ];

        return response($response, 200);
    }
}
