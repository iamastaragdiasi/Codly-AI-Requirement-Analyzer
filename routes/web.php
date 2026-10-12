<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ArtifactController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SourceController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->middleware('throttle:5,1');
Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::post('/projects/{project}/reviewer', [ProjectController::class, 'assign'])->name('projects.reviewer');
    Route::post('/projects/{project}/sources', [SourceController::class, 'store'])->name('sources.store');
    Route::post('/projects/{project}/analysis', [AnalysisController::class, 'store'])->middleware('throttle:10,1')->name('analysis.store');
    Route::post('/projects/{project}/reviews', [ArtifactController::class, 'store'])->name('reviews.store');
    Route::post('/projects/{project}/approvals', [ApprovalController::class, 'store'])->name('approvals.store');
    Route::post('/projects/{project}/proposal', [ProposalController::class, 'store'])->name('proposal.store');
});
