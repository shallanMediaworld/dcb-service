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
        Schema::table('sales', function (Blueprint $table) {

                 $table->unsignedBigInteger('lookup_id')->nullable()->after('gateway_id'); // Add the new column
                $table->foreign('lookup_id')->references('id')->on('lookups')->onDelete('cascade'); // Define the foreign key constraint
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['lookup_id']); // Drop the foreign key constraint
            $table->dropColumn('lookup_id'); // Drop the column
        });
    }
};
