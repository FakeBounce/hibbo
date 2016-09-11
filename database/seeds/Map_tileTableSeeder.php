<?php

use Illuminate\Database\Seeder;

class Map_tileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('map_tiles')->insert([
            'url' => '../../public/asset/img/grass.png',
            'break' => '0',
            'action' => 'none',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('map_tiles')->insert([
            'url' => '../../public/asset/img/grass_left_door.png',
            'break' => '1',
            'action' => 'kill_all',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('map_tiles')->insert([
            'url' => '../../public/asset/img/forest.png',
            'break' => '0',
            'action' => 'none',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);
    }
}
