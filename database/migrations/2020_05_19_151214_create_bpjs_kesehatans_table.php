<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBpjsKesehatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('bpjs_kesehatan', function (Blueprint $table) {
        $table->id();
        $table->float('company', 8, 2)->nullable();
        $table->float('employee', 8, 2)->nullable();
        $table->decimal('min', 12, 2)->nullable();
        $table->decimal('max', 12, 2)->nullable();
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
        Schema::dropIfExists('bpjs_kesehatan');
    }
}
