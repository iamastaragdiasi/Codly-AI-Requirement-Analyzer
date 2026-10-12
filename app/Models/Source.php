<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'user_id', 'kind', 'original', 'metadata'];

    protected function casts(): array
    {
        return ['metadata' => 'array'];
    }
}
