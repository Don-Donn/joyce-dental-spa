<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDentalRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dental_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('gingivitis')->nullable(); // Changed to TEXT for encryption
            $table->text('early')->nullable();
            $table->text('moderate')->nullable();
            $table->text('advance')->nullable();
            $table->text('class')->nullable();
            $table->text('overjet')->nullable();
            $table->text('overbite')->nullable();
            $table->text('midline')->nullable();
            $table->text('crossbite')->nullable();
            $table->text('ortho')->nullable();
            $table->text('stay')->nullable();
            $table->text('others')->nullable(); // Changed to TEXT for encryption
            $table->text('clenching')->nullable();
            $table->text('clicking')->nullable();
            $table->text('tris')->nullable();
            $table->text('muscle')->nullable();
            $table->timestamps();

            // Add a foreign key constraint for user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dental_records');
    }
}
