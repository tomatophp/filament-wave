<?php

namespace Wave\Seeders;

use Illuminate\Database\Seeder;

class ApiKeysTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('api_keys')->truncate();

    }
}
