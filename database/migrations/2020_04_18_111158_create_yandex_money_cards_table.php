<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYandexMoneyCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yandex_money_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("first6");
            $table->string("last4");
            $table->string("card_type");
            $table->string("method_id");
            $table->integer('yandex_money_payment_id')->unsigned()->index();
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
        Schema::dropIfExists('yandex_money_cards');
    }
}
