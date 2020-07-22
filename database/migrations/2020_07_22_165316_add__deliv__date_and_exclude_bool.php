<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDelivDateAndExcludeBool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_times', function (Blueprint $table) {
            $table->date('deliv_date')->default(\Carbon\Carbon::tomorrow());
            $table->boolean('excluded')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_times', function (Blueprint $table) {
            $table->dropColumn("deliv_date");
            $table->dropColumn("excluded");
        });
    }
}

