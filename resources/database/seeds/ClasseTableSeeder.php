<?php

use Illuminate\Database\Seeder;

class ClasseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classes')->insert([
            'name' => 'Warrior',
            'life' => '15000',
            'mana' => '1000',
            'armor' => '0',
            'damage' => '100',
            'range' => '1',
            'mv' => '2',
            'flat_dd' => '50',
            'percent_dd' => '0',
            'dr' => '0',
            'action' => '10',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);
    }
}
