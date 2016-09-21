<?php

use Illuminate\Database\Seeder;

class MonsterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('monsters')->insert([
            'name' => 'Man',
            'life' => '200',
            'armor' => '0',
            'damage' => '150',
            'range' => '1',
            'mv' => '1',
            'xp' => '1',
            'gold' => '1',
            'flat_dd' => '0',
            'percent_dd' => '0',
            'dr' => '0',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('monsters')->insert([
            'name' => 'Warrior',
            'life' => '300',
            'armor' => '100',
            'damage' => '250',
            'range' => '1',
            'mv' => '1',
            'xp' => '1',
            'gold' => '1',
            'flat_dd' => '0',
            'percent_dd' => '0',
            'dr' => '0',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('monsters')->insert([
            'name' => 'Ectoplasm',
            'life' => '500',
            'armor' => '0',
            'damage' => '550',
            'range' => '1',
            'mv' => '1',
            'xp' => '1',
            'gold' => '1',
            'flat_dd' => '0',
            'percent_dd' => '0',
            'dr' => '0',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('monsters')->insert([
            'name' => 'Basic_Boss',
            'life' => '10000',
            'armor' => '0',
            'damage' => '1000',
            'range' => '2',
            'mv' => '0',
            'xp' => '1',
            'gold' => '1',
            'flat_dd' => '0',
            'percent_dd' => '0',
            'dr' => '0',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('monsters')->insert([
            'name' => 'Healing_Orb',
            'life' => '100',
            'armor' => '0',
            'damage' => '0',
            'range' => '1',
            'mv' => '0',
            'xp' => '1',
            'gold' => '1',
            'flat_dd' => '0',
            'percent_dd' => '0',
            'dr' => '0',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);
    }
}
