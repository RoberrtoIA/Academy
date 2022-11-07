<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'created_at' => $this->whenNotNull($this->created_at ?? null),
            'updated_at' => $this->whenNotNull($this->updated_at ?? null),
            'deleted_at' => $this->whenNotNull($this->deleted_at ?? null),
            'module' => $this->whenLoaded('module'),
            'questions' => $this->whenLoaded('questions'),
        ];
    }
}
