<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSentCompanyMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sent_company_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->text('message');
            $table->enum('recipients', ['guests', 'employees']);
            $table->enum('cleared', ['yes', 'no'])->default('no');
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
        Schema::dropIfExists('sent_company_messages');
    }
}
