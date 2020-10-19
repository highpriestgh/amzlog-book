<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('number');
            $table->string('email');
            $table->date('date_of_birth');
            $table->string('phone');
            $table->integer('company');
            $table->integer('department');
            $table->enum('type', ['full_time', 'part_time', 'contract'])->default('full_time');
            $table->string('position');
            $table->text('thumbnail');
            $table->string('pass_code')->default('n/a');
            $table->enum('active', ['yes', 'no'])->default('yes');
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
        Schema::dropIfExists('employees');
    }
}
