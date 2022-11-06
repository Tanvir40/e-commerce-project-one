<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUptoDiscountCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upto_discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_name');
            $table->integer('amountone');
            $table->integer('amounttwo');
            $table->integer('discountone');
            $table->integer('amountthree');
            $table->integer('amountfour');
            $table->integer('discounttwo');
            $table->integer('amountfive');
            $table->integer('amountsix');
            $table->integer('discountthree');
            $table->integer('amountseven');
            $table->integer('amounteight');
            $table->integer('discountfour');
            $table->string('type');
            $table->date('validity');
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
        Schema::dropIfExists('upto_discount_coupons');
    }
}
