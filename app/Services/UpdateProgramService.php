<?php

namespace App\Services;

use App\Models\Program;

class UpdateProgramService
{
    public function __construct(protected CreateTagService $createTagService)
    {
    }

    public function updateProgram(Program $program, array $attributes): Program
    {
        $program->update($attributes);

        if ($attributes['tags'] ?? false) {

            $program->tags()->detach();

            $tags = $attributes['tags'];

            if (strpos($tags, ',') !== false) {

                $tags = explode(",", $tags);

                $tag_sync = [];

                foreach ($tags as $tag) {
                    $tags_sync[] = $this->createTagService->createTag($tag);
                }

                foreach ($tags_sync as $tag_sync) {
                    $program->tags()->attach($tag_sync);
                }
            } else {

                $tag_sync = $this->createTagService->createTag($tags);

                $program->tags()->attach($tag_sync);
            }

            $program->save();
        }

        return $program;
    }
}
