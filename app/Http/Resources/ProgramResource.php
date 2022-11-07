<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            // 'modules' => ModuleResource::collection($this->modules),
            // 'tags' => TagResource::collection($this->tags),
            'tags' => $this->loadedTags(),
            'modules' => $this->loadedModules(),
        ];
    }

    public function loadedTags()
    {
        if ($this->whenLoaded('tags')) {
            return TagResource::collection($this->tags);
        }
    }

    public function loadedModules()
    {
        if ($this->whenLoaded('modules')) {
            return ModuleResource::collection($this->modules);
        }
    }
}
