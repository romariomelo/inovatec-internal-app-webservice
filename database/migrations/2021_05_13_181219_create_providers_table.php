<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('trading_name');
            $table->string('company_name')->nullable();
            $table->string('ein');
            $table->string('state_registration')->nullable();
            $table->string('phone_number', 11)->nullable();
            $table->string('email', 150)->nullable();
            $table->boolean('provides_tef')->default(false);
            $table->boolean('provides_software')->default(false);
            $table->text('notes')->nullable();
            $table->unsignedInteger('created_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
