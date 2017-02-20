<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->bigInteger('damage');
            $table->bigInteger('time_damage');
            $table->bigInteger('buff_damage');
            $table->bigInteger('debuff_damage');
            $table->string('type_damage');
            $table->bigInteger('xp');
            $table->bigInteger('flat_dd');
            $table->bigInteger('flat_du');
            $table->bigInteger('percent_dd');
            $table->bigInteger('percent_du');
            $table->bigInteger('dr');
            $table->bigInteger('buff_life');
            $table->bigInteger('debuff_life');
            $table->bigInteger('heal');
            $table->bigInteger('time_heal');
            $table->bigInteger('forced_mv');
            $table->bigInteger('buff_mv');
            $table->bigInteger('debuff_mv');
            $table->bigInteger('duration');
            $table->bigInteger('mana');
            $table->bigInteger('cost_mana');
            $table->bigInteger('cost_life');
            $table->bigInteger('minimal_range');
            $table->bigInteger('linear_range');
            $table->bigInteger('diagonal_range');
            $table->bigInteger('linear_aoe');
            $table->bigInteger('diagonal_aoe');
            $table->bigInteger('up_aoe');
            $table->bigInteger('right_aoe');
            $table->bigInteger('down_aoe');
            $table->bigInteger('left_aoe');
            $table->bigInteger('cast');
            $table->bigInteger('action');
            $table->bigInteger('reset_cast');
            $table->bigInteger('break');
            $table->string('bonus_description');
            $table->string('description');
            $table->string('img');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('skills');
    }
}
