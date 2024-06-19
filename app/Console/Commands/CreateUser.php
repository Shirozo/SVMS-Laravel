<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {username} {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user';

    /**
     * Execute the console command.
     *
     *  @return init
     */
    public function handle()
    {
        $username = $this->argument("username");
        $name = $this->argument("name");
        $email = $this->argument("email");
        $password = $this->argument("password");

        $user = User::create([
            "username" => $username,
            "email" => $email,
            "name" => $name,
            "password" => Hash::make($password)
        ]);

        $this->info("Done...");

        return 0;
    }
}
