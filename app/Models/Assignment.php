<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'execution_id', 'module_id', 'user_id',
    ];

    protected $casts = [
        'homework_snapshot' => 'array',
        'interview_snapshot' => 'array',
    ];

    public function gradings() {
        return $this->hasMany(Grading::class);
    }

    public function module() {
        return $this->belongsTo(Module::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function execution() {
        return $this->belongsTo(Execution::class);
    }
}
