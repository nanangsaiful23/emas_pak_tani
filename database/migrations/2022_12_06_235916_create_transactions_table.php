<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')
                  ->nullable();
            $table->string('role')
                  ->nullable();
            $table->bigInteger('role_id')
                  ->nullable();
            $table->bigInteger('member_id')
                  ->unsigned()
                  ->nullable();
            $table->decimal('total_item_price', $precision = 14, $scale = 5)
                  ->nullable();
            $table->decimal('total_discount_price', $precision = 14, $scale = 5)
                  ->nullable();
            $table->decimal('total_sum_price', $precision = 14, $scale = 5)
                  ->nullable();
            $table->decimal('money_paid', $precision = 14, $scale = 5)
                  ->nullable();
            $table->decimal('money_returned', $precision = 14, $scale = 5)
                  ->nullable();
            $table->string('store')
                  ->comment('online/store location')
                  ->nullable();
            $table->string('payment')
                  ->comment('cash/credit')
                  ->nullable();
            $table->string('note')
                  ->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('member_id')
                  ->references('id')
                  ->on('members')
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
        Schema::dropIfExists('transactions');
    }
}
