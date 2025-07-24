<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Database\Seeder;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::create([
            'name' => 'Administrator'
        ]);
        Roles::create([
            'name' => 'Member'
        ]);

        User::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'phone_number' => '0777244375',
            'gender' => 'Female',
            'email' => 'jdoe@mailsac.com',
            'password' => bcrypt('jdoe@mailsac.com'),
            'physical_address' => 'Kira, Namugongo',
            'employer' => 'Lyptus Ventures',
            'employer_phone_number' => '0700429091',
            'status' => 1,
            'added_by' => 1,
        ]);

        UserRoles::create([
            'user_id' => 1,
            'roles_id' => 1
        ]);
        UserRoles::create([
            'user_id' => 1,
            'roles_id' => 2
        ]);
    }
}
