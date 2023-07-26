<?php

namespace Database\Seeders;

use App\Models\Hrm;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt("admin#123"),
            'lang' => 'en',
            'timezone' => setting('timezone'),
        ])->assignRole('Super Admin');

        Hrm::create([
            'user_id' => $user->id,
            'type' => 'company',
            'active_status' => 1,
        ]);
    }
}
