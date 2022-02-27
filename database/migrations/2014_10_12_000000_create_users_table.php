<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->dateTime('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('annual_income')->nullable();
            $table->string('occupation')->nullable();
            $table->string('family_type')->nullable();
            $table->string('manglik')->nullable();
            $table->string('partner_expected_income')->nullable();
            $table->json('partner_occupation')->nullable();
            $table->json('partner_family_type')->nullable();
            $table->string('partner_manglik')->nullable();
            $table->boolean('profile_status')->default(0)->nullable();
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
}
