<?php

namespace Wave\Seeders;

use Illuminate\Database\Seeder;

class ThemesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('themes')->truncate();

        \DB::table('themes')->insert([
            0 => [
                'id' => 1,
                'name' => 'Anchor Theme',
                'folder' => 'anchor',
                'active' => 1,
                'version' => 1.0,
            ],
        ]);

    }
}
