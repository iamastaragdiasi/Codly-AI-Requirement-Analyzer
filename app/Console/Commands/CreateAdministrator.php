<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAdministrator extends Command
{
    protected $signature = 'app:create-administrator {email} {name} {--reviewer : Grant reviewer permission}';

    protected $description = 'Provision a local account with a hidden password prompt; no default credentials';

    public function handle(): int
    {
        if (! $this->input->isInteractive()) {
            $this->error('Use an interactive terminal to enter a hidden password.');

            return self::FAILURE;
        }
        $data = ['email' => $this->argument('email'), 'name' => $this->argument('name'), 'password' => $this->secret('Password (at least 12 characters)')];
        $validator = Validator::make($data, ['email' => 'required|email|unique:users,email', 'name' => 'required|string|max:255', 'password' => 'required|string|min:12|max:255']);
        if ($validator->fails()) {
            $this->error('Invalid account details, duplicate email, or password shorter than 12 characters.');

            return self::FAILURE;
        }
        $user = new User($validator->validated());
        $user->is_reviewer = $this->option('reviewer');
        $user->save();
        $this->info('Account provisioned.');

        return self::SUCCESS;
    }
}
