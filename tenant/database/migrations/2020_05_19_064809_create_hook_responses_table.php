<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHookResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hook_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hook_id');
            $table->unsignedBigInteger('response_id');
            $table->string('status');
            $table->longText('response');
            $table->timestamps();

            $table->foreign('hook_id')->references('id')->on('hooks')->onDelete('cascade');
            $table->foreign('response_id')->references('id')->on('responses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hook_responses');
    }
}
