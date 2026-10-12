<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artifact extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'user_id', 'revision', 'kind', 'content'];

    protected function casts(): array
    {
        return ['content' => 'array'];
    }
}
