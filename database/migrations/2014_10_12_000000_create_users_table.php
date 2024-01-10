<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 60);
            //$table->string('curp', 18)->unique();
            //$table->string('rfc', 13)->unique();
            //$table->string('ine', 100);
            $table->string('facial_recognition')->nullable(true);
            $table->string('account_number', 18)->unique();
            $table->string('bank', 30);
            $table->string('shift', 30);
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('api_token', 255)->nullable(true);
            $table->boolean('paid')->default(false);
            $table->string('voucher')->nullable(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
