<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_name');
            $table->integer('discount')->nullable();
            $table->integer('amountone')->nullable();
            $table->integer('amounttwo')->nullable();
            $table->integer('discountone')->nullable();
            $table->integer('amountthree')->nullable();
            $table->integer('amountfour')->nullable();
            $table->integer('discounttwo')->nullable();
            $table->integer('amountfive')->nullable();
            $table->integer('amountsix')->nullable();
            $table->integer('discountthree')->nullable();
            $table->integer('amountseven')->nullable();
            $table->integer('amounteight')->nullable();
            $table->integer('discountfour')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
