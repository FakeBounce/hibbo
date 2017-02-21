<?php

use Illuminate\Database\Seeder;

class SkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([
            'id' => '1',
            'name'=> 'Attaque du bélier',
            'damage' => '3000',
            'time_damage' => '0',
            'buff_damage' => '0',
            'debuff_damage' => '0',
            'type_damage' => 'Aoe',
            'xp' => '0',
            'flat_dd' => '0',
            'flat_du' => '0',
            'percent_dd' => '0',
            'percent_du' => '0',
            'dr' => '0',
            'buff_life' => '0',
            'debuff_life' => '0',
            'heal' => '0',
            'time_heal' => '0',
            'forced_mv' => '4',
            'buff_mv' => '0',
            'debuff_mv' => '0',
            'duration' => '0',
            'mana' => '0',
            'cost_mana' => '1000',
            'cost_life' => '0',
            'minimal_range' => '0',
            'linear_range' => '1',
            'diagonal_range' => '0',
            'linear_aoe' => '4',
            'diagonal_aoe' => '0',
            'up_aoe' => '0',
            'right_aoe' => '0',
            'down_aoe' => '0',
            'left_aoe' => '0',
            'cast' => '0',
            'action' => '10',
            'reset_cast' => '0',
            'break' => '1',
            'bonus_description' => 'Peut casser certains murs',
            'description' => 'Vous foncez en ligne droite sur 4 cases, infligeant 3000 dégâts sur votre passage.',
            'img' => 'Bulls_charge.jpg',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('skills')->insert([
            'id' => '2',
            'name'=> 'Attaque tournoyante',
            'damage' => '0',
            'time_damage' => '0',
            'buff_damage' => '400',
            'debuff_damage' => '0',
            'type_damage' => 'Aoe',
            'xp' => '0',
            'flat_dd' => '0',
            'flat_du' => '0',
            'percent_dd' => '0',
            'percent_du' => '0',
            'dr' => '0',
            'buff_life' => '0',
            'debuff_life' => '0',
            'heal' => '0',
            'time_heal' => '0',
            'forced_mv' => '0',
            'buff_mv' => '0',
            'debuff_mv' => '0',
            'duration' => '0',
            'mana' => '0',
            'cost_mana' => '300',
            'cost_life' => '0',
            'minimal_range' => '0',
            'linear_range' => '0',
            'diagonal_range' => '0',
            'linear_aoe' => '0',
            'diagonal_aoe' => '1',
            'up_aoe' => '0',
            'right_aoe' => '0',
            'down_aoe' => '0',
            'left_aoe' => '0',
            'cast' => '0',
            'action' => '10',
            'reset_cast' => '0',
            'break' => '0',
            'bonus_description' => 'Non',
            'description' => 'Vous tournez sur vous même infligeant 400 dégâts en plus à tout les ennemis proches.',
            'img' => 'Cyclone_Axe.jpg',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('skills')->insert([
            'id' => '3',
            'name'=> 'Coupe veine',
            'damage' => '0',
            'time_damage' => '150',
            'buff_damage' => '0',
            'debuff_damage' => '0',
            'type_damage' => 'Dot',
            'xp' => '0',
            'flat_dd' => '0',
            'flat_du' => '0',
            'percent_dd' => '0',
            'percent_du' => '0',
            'dr' => '0',
            'buff_life' => '0',
            'debuff_life' => '0',
            'heal' => '0',
            'time_heal' => '0',
            'forced_mv' => '0',
            'buff_mv' => '0',
            'debuff_mv' => '0',
            'duration' => '10',
            'mana' => '0',
            'cost_mana' => '250',
            'cost_life' => '0',
            'minimal_range' => '0',
            'linear_range' => '1',
            'diagonal_range' => '0',
            'linear_aoe' => '0',
            'diagonal_aoe' => '0',
            'up_aoe' => '0',
            'right_aoe' => '0',
            'down_aoe' => '0',
            'left_aoe' => '0',
            'cast' => '0',
            'action' => '10',
            'reset_cast' => '0',
            'break' => '0',
            'bonus_description' => 'Non',
            'description' => 'Vous tailladez sauvagement l\'ennemi, le faisant saigner de 150hp pendant 10tours.',
            'img' => 'Gash.jpg',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('skills')->insert([
            'id' => '4',
            'name'=> 'Fuite',
            'damage' => '0',
            'time_damage' => '0',
            'buff_damage' => '0',
            'debuff_damage' => '0',
            'type_damage' => 'Buff',
            'xp' => '0',
            'flat_dd' => '0',
            'flat_du' => '0',
            'percent_dd' => '0',
            'percent_du' => '0',
            'dr' => '0',
            'buff_life' => '0',
            'debuff_life' => '0',
            'heal' => '0',
            'time_heal' => '0',
            'forced_mv' => '0',
            'buff_mv' => '2',
            'debuff_mv' => '0',
            'duration' => '2',
            'mana' => '0',
            'cost_mana' => '100',
            'cost_life' => '0',
            'minimal_range' => '0',
            'linear_range' => '0',
            'diagonal_range' => '0',
            'linear_aoe' => '0',
            'diagonal_aoe' => '0',
            'up_aoe' => '0',
            'right_aoe' => '0',
            'down_aoe' => '0',
            'left_aoe' => '0',
            'cast' => '0',
            'action' => '0',
            'reset_cast' => '0',
            'break' => '0',
            'bonus_description' => 'Non',
            'description' => 'Vous gagnez 2 en déplacement pendant 2tours.',
            'img' => 'Sprint.jpg',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('skills')->insert([
            'id' => '5',
            'name'=> 'Guérison des plaies',
            'damage' => '0',
            'time_damage' => '0',
            'buff_damage' => '0',
            'debuff_damage' => '0',
            'type_damage' => 'Heal',
            'xp' => '0',
            'flat_dd' => '0',
            'flat_du' => '0',
            'percent_dd' => '0',
            'percent_du' => '0',
            'dr' => '0',
            'buff_life' => '0',
            'debuff_life' => '0',
            'heal' => '1500',
            'time_heal' => '0',
            'forced_mv' => '0',
            'buff_mv' => '0',
            'debuff_mv' => '0',
            'duration' => '0',
            'mana' => '0',
            'cost_mana' => '200',
            'cost_life' => '0',
            'minimal_range' => '0',
            'linear_range' => '0',
            'diagonal_range' => '0',
            'linear_aoe' => '0',
            'diagonal_aoe' => '0',
            'up_aoe' => '0',
            'right_aoe' => '0',
            'down_aoe' => '0',
            'left_aoe' => '0',
            'cast' => '0',
            'action' => '10',
            'reset_cast' => '0',
            'break' => '0',
            'bonus_description' => 'Non',
            'description' => 'Vous vous soignez de 1500hp.',
            'img' => 'Healing_Signet.jpg',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('skills')->insert([
            'id' => '6',
            'name'=> 'Guillotine',
            'damage' => '1400',
            'time_damage' => '0',
            'buff_damage' => '0',
            'debuff_damage' => '0',
            'type_damage' => 'Buff',
            'xp' => '0',
            'flat_dd' => '0',
            'flat_du' => '0',
            'percent_dd' => '0',
            'percent_du' => '0',
            'dr' => '0',
            'buff_life' => '0',
            'debuff_life' => '0',
            'heal' => '0',
            'time_heal' => '0',
            'forced_mv' => '0',
            'buff_mv' => '0',
            'debuff_mv' => '0',
            'duration' => '2',
            'mana' => '0',
            'cost_mana' => '700',
            'cost_life' => '0',
            'minimal_range' => '0',
            'linear_range' => '0',
            'diagonal_range' => '0',
            'linear_aoe' => '0',
            'diagonal_aoe' => '0',
            'up_aoe' => '0',
            'right_aoe' => '0',
            'down_aoe' => '0',
            'left_aoe' => '0',
            'cast' => '0',
            'action' => '0',
            'reset_cast' => '0',
            'break' => '0',
            'bonus_description' => 'Non',
            'description' => 'Vos prochaines attaques infligeront 1400 dégâts en plus, dure 2tours.',
            'img' => 'Disrupting_Chop.jpg',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);

        DB::table('skills')->insert([
            'id' => '7',
            'name'=> 'Resistance a la douleur',
            'damage' => '0',
            'time_damage' => '0',
            'buff_damage' => '0',
            'debuff_damage' => '0',
            'type_damage' => 'Buff',
            'xp' => '0',
            'flat_dd' => '300',
            'flat_du' => '0',
            'percent_dd' => '0',
            'percent_du' => '0',
            'dr' => '0',
            'buff_life' => '0',
            'debuff_life' => '0',
            'heal' => '0',
            'time_heal' => '0',
            'forced_mv' => '0',
            'buff_mv' => '0',
            'debuff_mv' => '0',
            'duration' => '3',
            'mana' => '0',
            'cost_mana' => '400',
            'cost_life' => '0',
            'minimal_range' => '0',
            'linear_range' => '0',
            'diagonal_range' => '0',
            'linear_aoe' => '0',
            'diagonal_aoe' => '0',
            'up_aoe' => '0',
            'right_aoe' => '0',
            'down_aoe' => '0',
            'left_aoe' => '0',
            'cast' => '0',
            'action' => '0',
            'reset_cast' => '10',
            'break' => '0',
            'bonus_description' => 'Non',
            'description' => 'Vous réduisez de 300 les dégâts des 3 prochains tours.',
            'img' => 'defy_pain.jpg',
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now()
        ]);
    }
}