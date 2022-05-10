<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('basket_id');
            $table->string('token_name');
            $table->bigInteger('token_id');
            $table->string('leg_type');
            $table->integer('qty');
            $table->string('status');
            $table->double('delta')->nullable();
            $table->double('theta')->nullable();
            $table->double('vega')->nullable();
            $table->double('gamma')->nullable();
            $table->string('order_type');
            $table->bigInteger('order_id')->nullable();
            $table->dateTime('order_date_time', 0)->nullable();
            $table->string('order_avg_price', 0)->nullable();
            $table->double('ltp')->nullable();
            $table->double('pnl')->nullable();
            $table->double('exit_price')->nullable();
            $table->integer('is_delete')->nullable();
            $table->timestamps();
            
            $table->foreign('basket_id')->references('id')->on('baskets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('baskets')->onDelete('cascade');
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
