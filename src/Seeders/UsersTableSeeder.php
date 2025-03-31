<?php

namespace Wave\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('users')->truncate();

        \DB::table('users')->insert([
            0 => [
                'id' => 1,
                'name' => 'Wave Admin',
                'email' => 'admin@admin.com',
                'username' => 'admin',
                'avatar' => 'demo/default.png',
                'password' => bcrypt('password'),
                'remember_token' => '4oXDVo48Lm1pc4j7NkWI9cMO4hv5OIEJFMrqjSCKQsIwWMGRFYDvNpdioBfo',
                'created_at' => '2017-11-21 16:07:22',
                'updated_at' => '2018-09-22 23:34:02',
                'trial_ends_at' => null,
                'verification_code' => null,
                'verified' => 1,
            ],
        ]);

    }
}
