<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageCaroselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_carosels', function (Blueprint $table) {
            $table->id();
            $table->string('small_text');
            $table->string('thin_large_text');
            $table->string('thik_large_text');
            $table->string('small_title');
            $table->integer('price');
            $table->integer('discount_price');
            $table->string('product_url');
            $table->string('carousel_image')->nullable();
            $table->integer('status')->default(2);
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
        Schema::dropIfExists('image_carosels');
    }
}
