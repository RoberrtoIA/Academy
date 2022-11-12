<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function abilities()
    {
        return $this->belongsToMany(Ability::class);
    }
}