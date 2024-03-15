<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCokimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cokims', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('weight')
                  ->nullable();
            $table->string('status')
                  ->comment('sell/sold')
                  ->nullable();
            $table->string('production_price')
                  ->nullable();
            $table->string('selling_price')
                  ->nullable();

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
        Schema::dropIfExists('cokims');
    }
}
