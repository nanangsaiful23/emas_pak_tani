<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')
                  ->unsigned()
                  ->nullable();
            $table->bigInteger('brand_id')
                  ->unsigned()
                  ->nullable();
            $table->boolean('is_old_gold')
                  ->default(0)
                  ->nullable();
            $table->string('code')
                  ->unique()
                  ->nullable();
            $table->string('name')
                  ->nullable();
            $table->bigInteger('percentage_id')
                  ->unsigned()
                  ->nullable();
            $table->string('weight')
                  ->nullable();
            $table->string('status')
                  ->nullable();
            $table->string('gold_history_number')
                  ->nullable();
            $table->longText('description')
                  ->nullable();
            $table->string('stone_weight')
                  ->nullable();
            $table->string('stone_price')
                  ->nullable();
            $table->bigInteger('last_distributor_id')
                  ->unsigned()
                  ->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');

            $table->foreign('brand_id')
                  ->references('id')
                  ->on('brands')
                  ->onDelete('cascade');

            $table->foreign('percentage_id')
                  ->references('id')
                  ->on('percentages')
                  ->onDelete('cascade');

            $table->foreign('last_distributor_id')
                  ->references('id')
                  ->on('distributors')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
