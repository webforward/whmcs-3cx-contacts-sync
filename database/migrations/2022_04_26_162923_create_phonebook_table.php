<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonebookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phonebook', function (Blueprint $table) {
            $table->id('idphonebook');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('phonenumber')->nullable();
            $table->integer('fkidtenant')->nullable();
            $table->integer('fkiddn')->nullable();
            $table->string('company')->nullable();
            $table->string('tag')->nullable();
            $table->string('pv_an5')->nullable();
            $table->string('pv_an0')->nullable();
            $table->string('pv_an1')->nullable();
            $table->string('pv_an2')->nullable();
            $table->string('pv_an3')->nullable();
            $table->string('pv_an4')->nullable();
            $table->string('pv_an6')->nullable();
            $table->string('pv_an7')->nullable();
            $table->string('pv_an8')->nullable();
            $table->string('pv_an9')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phonebook');
    }
}
