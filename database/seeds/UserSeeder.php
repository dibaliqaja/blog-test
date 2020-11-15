<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->create();

        DB::table('users')->insert(
            [
                'name' => 'Administrator',
                'email' => 'admin@blogtest.com',
                'email_verified_at' => now(),
                'password' => bcrypt('admin123'),
                'remember_token' => Str::random(10),
                'role' => json_encode(["ADMIN"]),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
