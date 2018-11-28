<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AccessToken
 * @author Cookie
 */
class AccessToken extends Migration
{
    /**
     * @author Cookie
     */
    public function up()
    {
        Schema::create("access_tokens", function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text("data");
            $table->string("uid");
            $table->string("refresh_token");
            $table->string("exp");
        });
    }

    /**
     * @author Cookie
     */
    public function down()
    {
        Schema::drop("access_tokens");
    }
}
