<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('trading_name', 200);
            $table->string('company_name', 200);
            $table->string('ein', 18);
            $table->string('state_registration', 20)->nullable();
            $table->string('phone_number', 15)->nullable();
            $table->string('email', 200)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('clients');
    }
}
