<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExecutionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return collect(parent::toArray($request))
            ->merge([
                'program' => new ProgramResource($this->whenLoaded('program')),
                'trainers' => UserResource::collection($this->whenLoaded('trainers')),
                'program_execution_content' => $this->whenNotNull($this->program_execution_content),
                'finished' => $this->whenNotNull($this->finished),
                'deleted_at' => $this->whenNotNull($this->deleted_at),
            ])->toArray();
    }
}
