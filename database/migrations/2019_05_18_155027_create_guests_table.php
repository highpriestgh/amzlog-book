<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('origin');
            $table->integer('host_company');
            $table->integer('host_department');
            $table->integer('host');
            $table->string('visit_reason');
            $table->text('thumbnail');
            $table->string('code')->default('n/a');
            $table->enum('logged_out', ['yes', 'no'])->default('no');
            $table->dateTime('time_in')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('time_out')->default('1000-01-01 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guests');
    }
}
