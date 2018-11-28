<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AccessToken
 * @author Martin Osusky
 */
class AccessToken extends Migration
{
    /**
     * @author Martin Osusky
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
     * @author Martin Osusky
     */
    public function down()
    {
        Schema::drop("access_tokens");
    }
}
