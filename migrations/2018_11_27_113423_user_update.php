<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class UserNull
 * @author Cookie
 */
class UserUpdate extends Migration
{
    /**
     * @author Cookie
     */
    public function up()
    {
        Schema::table("users", function (Blueprint $table) {
            $table->string('uid')->nullable();
            $table->string('csm')->nullable();
            $table->string('auv')->nullable();
            $table->string('mro')->nullable();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('state')->nullable();
            $table->string('country_id')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('post_code')->nullable();
            $table->string('username')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('checksum')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('language')->nullable();
            $table->string('lid')->nullable();
            $table->string('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
