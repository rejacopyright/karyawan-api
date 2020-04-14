<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('setting', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable();
        $table->string('image')->nullable();
        $table->text('desc')->nullable();
        $table->dateTime('in')->nullable();
        $table->dateTime('out')->nullable();
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
        Schema::dropIfExists('setting');
    }
}
