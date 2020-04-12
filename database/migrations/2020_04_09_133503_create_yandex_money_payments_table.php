<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYandexMoneyPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yandex_money_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount',12,2);
            $table->integer('yandex_money_status_id')->unsigned()->index();
            $table->integer('order_id')->unsigned()->index();
            $table->string('payment_id')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('yandex_money_payments');
    }
}
