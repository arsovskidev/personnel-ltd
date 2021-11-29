<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            // Using UUID instead of auto increment.
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable(false);
            $table->uuid('client_id')->nullable(false);
            $table->enum('client_type', ['Carer', 'Nurse']);
            $table->enum('type', ['Incoming', 'Outgoing']);
            $table->integer('duration');
            $table->integer('score');
            $table->dateTime('date');
            $table->timestamps();

            // Create foreign keys for user_id to users table and client_id to clients table.
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calls');
    }
}
