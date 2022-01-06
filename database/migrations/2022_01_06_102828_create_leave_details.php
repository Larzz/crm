<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leave_id');
            $table->dateTime('leave_from');
            $table->dateTime('leave_to');
            $table->integer('number_of_day');
            $table->boolean('status');
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
        Schema::table('leave_details', function (Blueprint $table) {
            Schema::dropIfExists('leave_details');
        });
    }
}
