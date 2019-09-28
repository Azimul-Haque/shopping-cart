<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('imagetrackcode');
            $table->string('title')->unique();
            $table->string('shorttext');
            $table->text('description');
            $table->float('oldprice')->default(0);
            $table->float('price');
            $table->integer('stock')->default(0);
            $table->string('isAvailable');


            $table->float('buying_price');
            $table->float('carrying_cost')->default(0);
            $table->float('vat')->default(0);
            $table->float('salary')->default(0);
            $table->float('wages')->default(0);
            $table->float('utility')->default(0);
            $table->float('others')->default(0);
            $table->float('profit')->default(0);

            $table->integer('category_id')->unsigned();
            $table->integer('subcategory_id')->unsigned();

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
        Schema::drop('products');
    }
}
