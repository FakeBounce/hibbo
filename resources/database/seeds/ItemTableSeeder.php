<?php

use Illuminate\Database\Seeder;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            'url' => 'redpotion.png',
            'name' => 'Potion de vitalité',
            'type' => 'consummable',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('items')->insert([
            'url' => 'bluepotion.png',
            'name' => 'Potion d\'énergie',
            'type' => 'consummable',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);
    }
}
