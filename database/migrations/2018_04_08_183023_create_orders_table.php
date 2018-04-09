<?php

use Illuminate\Support\Facades\DB;
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
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('card_number');
            $table->string('card_holder_name');
            $table->string('card_expirity_month');
            $table->string('card_expirity_year');
            $table->float('amount', 10, 2);
            $table->string('card_cvv');
            $table->string('country');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zipcode');
            $table->string('phone_number');
            $table->string('email');
            $table->string('ip_address');
            $table->string('order')->nullable();
            $table->string('order_description')->nullable();
            $table->string('response_code')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('response')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE orders AUTO_INCREMENT = 1001;");
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
