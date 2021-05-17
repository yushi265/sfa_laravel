<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actlogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('route')->nullable();
            $table->string('url')->nullable();
            $table->string('method')->nullable();
            $table->unsignedBigInteger('status')->nullable();
            $table->text('message')->nullable();
            $table->string('remote_addr')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->index(['created_at']);
            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actlogs');
    }
}
