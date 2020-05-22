<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBpjsKetenagakerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('bpjs_ketenagakerjaan', function (Blueprint $table) {
         $table->id();
         $table->float('jht_company', 8, 2)->nullable();
         $table->float('jht_employee', 8, 2)->nullable();
         $table->float('jht_min', 12, 2)->nullable();
         $table->float('jht_max', 12, 2)->nullable();
         $table->float('jkk_company', 8, 2)->nullable();
         $table->float('jkk_employee', 8, 2)->nullable();
         $table->float('jkk_min', 12, 2)->nullable();
         $table->float('jkk_max', 12, 2)->nullable();
         $table->float('jkm_company', 8, 2)->nullable();
         $table->float('jkm_employee', 8, 2)->nullable();
         $table->float('jkm_min', 12, 2)->nullable();
         $table->float('jkm_max', 12, 2)->nullable();
         $table->float('jp_company', 8, 2)->nullable();
         $table->float('jp_employee', 8, 2)->nullable();
         $table->float('jp_min', 12, 2)->nullable();
         $table->float('jp_max', 12, 2)->nullable();
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
        Schema::dropIfExists('bpjs_ketenagakerjaan');
    }
}
