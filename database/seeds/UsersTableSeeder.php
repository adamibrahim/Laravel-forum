<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'        => 'Admin Ibrahim',
            'email'        => 'adamibrahim1701@gmail.com',
            'password'        => Hash::make('secret'),
            'created_at'        => Carbon::now(),
        ]);

        DB::table('role_user')->insert([
            'user_id'        => 1,
            'role_id'        => 1,
        ]);

        $this->command->info('User seeding successful.');
    }
}
