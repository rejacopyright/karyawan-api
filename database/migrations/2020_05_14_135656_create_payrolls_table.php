<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payroll_id')->nullable();
            $table->text('jabatan_id')->nullable(); // Array
            $table->integer('all_jabatan')->nullable(); // 1 = Berlaku untuk semua jabatan, 0/null = Return to "jabatan_id"
            $table->string('name')->nullable();
            $table->integer('type')->nullable(); // 1 = increment, 0/null = decrement
            $table->integer('percent')->nullable(); // if 1, its linked to percent of salary in jabatan
            $table->decimal('value', 12, 0)->nullable(); // Satuan rupiah jika kolom percentnya 0 atau null, jika kolom percentnya 1, maka satuannya persen 1 - 100
            $table->text('desc')->nullable();
            $table->integer('lifetime')->nullable(); // 1 = yes, 0/null = no
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
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
        Schema::dropIfExists('payroll');
    }
}
