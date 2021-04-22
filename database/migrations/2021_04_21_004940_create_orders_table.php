<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_name', 80);
            $table->string('customer_email', 120);
            $table->string('customer_mobile', 40);
            $table->integer('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->decimal('amount', 16, 0);
            $table->string('status', 20)->default('CREATED');
            $table->integer('requestId')->nullable();
            $table->string('ipAddress', 15);
            $table->string('payment_status', 18)->nullable();
            $table->string('payment_reason', 3)->nullable();
            $table->string('payment_message', 200)->nullable();
            $table->string('payment_date', 200)->nullable();
            $table->string('payment_reference', 30)->nullable();
            $table->string('payment_authorization', 20)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
