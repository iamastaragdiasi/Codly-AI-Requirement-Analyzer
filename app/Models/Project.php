<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reviewer_id', 'name', 'business_problem', 'objectives', 'target_users', 'revision'];

    public function sources(): HasMany
    {
        return $this->hasMany(Source::class);
    }

    public function analyses(): HasMany
    {
        return $this->hasMany(Analysis::class);
    }

    public function artifacts(): HasMany
    {
        return $this->hasMany(Artifact::class);
    }

    public function auditEvents(): HasMany
    {
        return $this->hasMany(AuditEvent::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class);
    }

    public function isApproved(): bool
    {
        return $this->approvals()->where('revision', $this->revision)->latest('id')->value('decision') === 'approved';
    }
}
