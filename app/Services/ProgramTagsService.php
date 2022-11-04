<?php

namespace App\Services;

use App\Models\Program;
use App\Models\Tag;

class ProgramTagsService
{
    public function __construct(protected CreateTagService $createTagService)
    {
    }

    public function createProgram($attributes)
    {
        $tags = $attributes['tags'];

        unset($attributes['tags']);

        $program = Program::create($attributes);

        if (strpos($tags, ',') !== false) {

            $tags = explode(",", $tags);

            $tag_sync = [];

            foreach ($tags as $tag) {
                $tags_sync[] = $this->createTagService->createTag($tag);;
            }

            foreach ($tags_sync as $tag_sync) {
                $program->tags()->attach($tag_sync);
            }
        } else {

            $tag_sync = $this->createTagService->createTag($tags);

            $program->tags()->attach($tag_sync);
        }

        $program->save();

        return $program;
    }
}
