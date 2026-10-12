<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t): void {
            $t->boolean('is_reviewer')->default(false);
        });
        Schema::create('projects', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('user_id')->constrained()->restrictOnDelete();
            $t->foreignId('reviewer_id')->nullable()->constrained('users')->restrictOnDelete();
            $t->string('name');
            $t->text('business_problem');
            $t->text('objectives');
            $t->text('target_users');
            $t->unsignedInteger('revision')->default(1);
            $t->timestamps();
        });
        Schema::create('sources', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('project_id')->constrained()->restrictOnDelete();
            $t->foreignId('user_id')->constrained()->restrictOnDelete();
            $t->string('kind');
            $t->longText('original');
            $t->json('metadata');
            $t->timestamps();
        });
        Schema::create('analyses', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('project_id')->constrained()->restrictOnDelete();
            $t->unsignedInteger('revision');
            $t->string('status');
            $t->string('provider')->default('deterministic-demo');
            $t->json('results');
            $t->json('failures');
            $t->timestamps();
        });
        Schema::create('artifacts', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('project_id')->constrained()->restrictOnDelete();
            $t->foreignId('user_id')->constrained()->restrictOnDelete();
            $t->unsignedInteger('revision');
            $t->string('kind');
            $t->json('content');
            $t->timestamps();
        });
        Schema::create('approvals', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('project_id')->constrained()->restrictOnDelete();
            $t->foreignId('user_id')->constrained()->restrictOnDelete();
            $t->unsignedInteger('revision');
            $t->string('decision');
            $t->text('notes');
            $t->timestamps();
        });
        Schema::create('audit_events', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('project_id')->constrained()->restrictOnDelete();
            $t->foreignId('user_id')->constrained()->restrictOnDelete();
            $t->unsignedInteger('revision');
            $t->string('action');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['audit_events', 'approvals', 'artifacts', 'analyses', 'sources', 'projects'] as $table) {
            if (DB::table($table)->exists()) {
                throw new RuntimeException('Rollback refused for populated workspace tables. Use a forward migration.');
            }
        }
        foreach (['audit_events', 'approvals', 'artifacts', 'analyses', 'sources', 'projects'] as $table) {
            Schema::dropIfExists($table);
        }
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn('is_reviewer'));
    }
};
