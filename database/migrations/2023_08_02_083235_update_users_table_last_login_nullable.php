<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableLastLoginNullable extends Migration
{

    public function __construct()
    {
        // ! This is to allow changing timestamps without forcing require dbal on non dev composer.
        \Doctrine\DBAL\Types\Type::addType(
            'timestamp',
            \Illuminate\Database\DBAL\TimestampType::class
        );
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_login')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
        });
    }
};
