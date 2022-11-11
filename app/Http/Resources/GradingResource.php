<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GradingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'comments' => $this->comments,
            'grade' => $this->grade,
            'snapshot' => $this->snapshot,
            'created_at' => $this->whenNotNull($this->created_at ?? null),
            'updated_at' => $this->whenNotNull($this->updated_at ?? null),
            'deleted_at' => $this->whenNotNull($this->deleted_at ?? null),
            'gradable' => $this->whenLoaded('gradable'),
            'assignment' => new AssignmentResource($this->whenLoaded('assignment')),
        ];
    }
}
