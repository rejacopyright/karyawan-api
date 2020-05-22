<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePphPtkpsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('pph_ptkp', function (Blueprint $table) {
      $table->id();
      $table->decimal('tk', 12, 2)->nullable();
      $table->decimal('k', 12, 2)->nullable();
      $table->decimal('ki', 12, 2)->nullable();
      $table->decimal('tanggungan', 12, 2)->nullable();
      $table->integer('max')->nullable();
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
    Schema::dropIfExists('pph_ptkp');
  }
}
