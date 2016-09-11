<?php

use Illuminate\Database\Seeder;

class MapTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('maps')->insert([
        'name' => 'Découverte',
        'tile_set' => '',
        'width' => '10',
        'height' => '10',
        'floor' => '0',
        'description' => 'Découverte',
        'created_at' => Carbon\Carbon::now(),
        'updated_at' => Carbon\Carbon::now()
        ]);
    }
}
