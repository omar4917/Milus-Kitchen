<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user (like Django\'s createsuperuser)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Create Admin User ===');
        $this->newLine();

        $name = $this->ask('Full name');

        $email = $this->ask('Email address');

        // Validate email
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $this->error('Invalid email address.');
            return 1;
        }

        // Check if user already exists
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            if (!$this->confirm("A user with email '{$email}' already exists. Update them to admin?")) {
                $this->info('Aborted.');
                return 0;
            }

            $password = $this->secret('New password (min 4 characters)');
            $existingUser->update([
                'name' => $name,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);

            $this->newLine();
            $this->info("✅ User '{$email}' has been updated to admin.");
            return 0;
        }

        $password = $this->secret('Password (min 4 characters)');
        $passwordConfirm = $this->secret('Confirm password');

        if ($password !== $passwordConfirm) {
            $this->error('Passwords do not match.');
            return 1;
        }

        if (strlen($password) < 4) {
            $this->error('Password must be at least 4 characters.');
            return 1;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->newLine();
        $this->info("✅ Admin user '{$email}' created successfully!");

        return 0;
    }
}
