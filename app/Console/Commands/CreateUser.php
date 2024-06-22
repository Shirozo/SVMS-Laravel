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
    protected $signature = 'admin:create';

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
        $user = User::create([
            "username" => "admin",
            "email" => "admin@mail.com",
            "first_name" => "admin",
            "middle_name" => "admin",
            "last_name" => "admin",
            "user_type" => 1,
            "student_id" => 1,
            "password" => Hash::make("admin")
        ]);

        $this->info("Done...");

        return 0;
    }
}
