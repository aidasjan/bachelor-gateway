<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 512);
            $table->string('email_h', 128)->unique();
            $table->string('email', 512);
            $table->string('role', 512);
            $table->tinyInteger('is_new')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('access_token')->nullable();
            $table->string('password_reset_token')->nullable();
            $table->date('password_reset_date')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
