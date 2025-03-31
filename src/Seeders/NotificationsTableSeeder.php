<?php

namespace Wave\Seeders;

use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('notifications')->truncate();

    }
}
