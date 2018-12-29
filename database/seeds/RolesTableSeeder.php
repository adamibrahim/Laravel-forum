<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'          => 'Admin',
            'description'   => 'Moderator with access to everything',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name'          => 'User',
            'description'   => 'User role to endit profile, read comments threads and manage own threads',
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        $this->command->info('Roles seeding successful.');
    }
}
