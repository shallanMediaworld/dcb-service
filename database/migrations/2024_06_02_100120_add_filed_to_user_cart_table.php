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
        Schema::table('user_cart', function (Blueprint $table) {
            //
            $table->boolean('is_avalible')->default(false);
            $table->string('reason_unavailable')->nullable();
            $table->unsignedBigInteger('payment_channel_id')->nullable();
            $table->foreign('payment_channel_id')->references('id')->on('payment_channels');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_cart', function (Blueprint $table) {
            //
        });
    }
};
