<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Homework extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = "homeworks";

    protected $fillable = ['doc', 'module_id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
