<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'revision', 'status', 'provider', 'results', 'failures'];

    protected function casts(): array
    {
        return ['results' => 'array', 'failures' => 'array'];
    }
}
