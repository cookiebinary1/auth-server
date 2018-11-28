<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class UserNull
 * @author Martin Osusky
 */
class UserUpdate extends Migration
{
    const COLUMNS = [
        'uid',
        'csm',
        'auv',
        'mro',
        'title',
        'first_name',
        'last_name',
        'middle_name',
        'state',
        'country_id',
        'city',
        'address',
        'post_code',
        'username',
        'date_of_birth',
        'checksum',
        'phone_number',
        'language',
        'lid',
        'user_id',
        'name',
        "email_verification",
        "country",
    ];

    /**
     * @author Martin Osusky
     */
    public function up()
    {
        Schema::table("users", function (Blueprint $table) {
            foreach (self::COLUMNS as $column) {
                if (!Schema::hasColumn("users", $column)) {
                    $table->string($column)->nullable();
                }
            }
        });

        Schema::table("users", function (Blueprint $table) {
            foreach (self::COLUMNS as $column) {
                if (Schema::hasColumn("users", $column)) {
                    $table->string($column)->nullable()->change();
                }
            }
        });
    }

    /**
     * @author Martin Osusky
     */
    public function down()
    {
        // do nothing because we do not know which columns are created by this migration
    }
}
