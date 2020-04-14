<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->dateTime('in')->nullable();
            $table->dateTime('out')->nullable();
            $table->integer('status')->nullable(); // 0:bolos, 1:masuk, 2:telat, 3:ijin, 4:cuti, 5:apps
            $table->text('alasan')->nullable();
            $table->integer('approve')->nullable(); // 1:yes
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
        Schema::dropIfExists('absensi');
    }
}
