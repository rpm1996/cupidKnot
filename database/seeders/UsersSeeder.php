<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 4; $i++) { 
            DB::table('users')->insert([ 
                'first_name' => Str::random(10),
                'last_name' => Str::random(10),
                'email' => Str::random(10).'@gmail.com',
                'password' => Hash::make('Rr123456'),
                'dob' => date('Y-m-d h:i:s'),
                'gender' => "Male",
                'annual_income' => mt_rand(100000,999999),
                'occupation' => "Government Job",
                'family_type' => "Joint Family",
                'manglik' => "No",
                'partner_expected_income' => mt_rand(100000,999999).' - '.mt_rand(100000,999999),
                'partner_occupation' => json_encode(array('Government Job', 'Business')),
                'partner_family_type' => json_encode(array('Nuclear Family')),
                'partner_manglik' => "No",
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]);
        }
    }
}
