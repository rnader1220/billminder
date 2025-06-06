<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run()
    {
		$created_at = Carbon::now();
        $user_id = DB::table('users')->insert([

            'name' => encrypt('administrator'), 
			'password' => Hash::make('administrator'),
            'email' => 'admin@dyn-it.com',
            'created_at' => $created_at,
            'updated_at' => $created_at,
            'email_verified_at' => $created_at
        ]);

    }
}
