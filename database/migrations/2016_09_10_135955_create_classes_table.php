<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->bigInteger('life');
            $table->bigInteger('mana');
            $table->bigInteger('armor');
            $table->bigInteger('damage');
            $table->bigInteger('range');
            $table->bigInteger('mv');
            $table->bigInteger('flat_dd');
            $table->bigInteger('percent_dd');
            $table->bigInteger('dr');
            $table->bigInteger('action');
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
        Schema::drop('classes');
    }
}
