<?php

namespace Wave\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        \DB::table('roles')->truncate();

        \DB::table('roles')->insert([
            0 => [
                'id' => 1,
                'guard_name' => 'web',
                'name' => 'admin',
                'created_at' => '2017-11-21 16:23:22',
                'updated_at' => '2017-11-21 16:23:22',
            ],
            1 => [
                'id' => 2,
                'guard_name' => 'accounts',
                'name' => 'registered',
                'created_at' => '2017-11-21 16:23:22',
                'updated_at' => '2017-11-21 16:23:22',
            ],
            2 => [
                'id' => 3,
                'guard_name' => 'accounts',
                'name' => 'basic',
                'created_at' => '2017-11-21 16:23:22',
                'updated_at' => '2017-11-21 16:23:22',
            ],
            3 => [
                'id' => 4,
                'guard_name' => 'accounts',
                'name' => 'premium',
                'created_at' => '2018-07-03 05:03:21',
                'updated_at' => '2018-07-03 17:28:44',
            ],
            4 => [
                'id' => 5,
                'guard_name' => 'accounts',
                'name' => 'pro',
                'created_at' => '2018-07-03 16:27:16',
                'updated_at' => '2018-07-03 17:28:38',
            ],
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
