<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gender_id')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('job_id')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('status_id')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('contract_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contract_type_id')->unique();
            $table->string('name');
            $table->timestamps();
        });


        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('ruby');
            $table->unsignedBigInteger('gender_id');
            $table->date('birth');
            $table->unsignedBigInteger('tel');
            $table->string('address');
            $table->string('mail')->nullable();
            $table->unsignedBigInteger('job_id');
            $table->string('company')->nullable();
            $table->timestamps();

            $table->foreign('gender_id')->references('gender_id')->on('genders');
            $table->foreign('job_id')->references('job_id')->on('jobs');
        });

        Schema::create('progresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('status_id');
            $table->text('body');
            $table->timestamps();

            $table
                ->foreign('status_id')
                ->references('status_id')
                ->on('statuses');
            // ユーザーIDを紐づけ
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            // 顧客IDを紐づけ
            $table
                ->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
        });

        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('contract_type_id');
            $table->bigInteger('amount');
            $table->date('due_date')->nullable();
            $table->timestamps();

            $table
                ->foreign('contract_type_id')
                ->references('contract_type_id')
                ->on('contract_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('progresses');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('contract_types');
        Schema::dropIfExists('genders');
    }
}
