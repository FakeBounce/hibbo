<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MapTableSeeder::class);
        $this->call(Map_tileTableSeeder::class);
        $this->call(MonsterTableSeeder::class);
        $this->call(ItemTableSeeder::class);
        $this->call(ClasseTableSeeder::class);
        $this->call(SkillTableSeeder::class);
    }
}
