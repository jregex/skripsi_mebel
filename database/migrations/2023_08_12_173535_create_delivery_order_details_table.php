<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_order_details', function (Blueprint $table) {
            $table->id();
            $table->string('kode_delivery_order');
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->bigInteger('jumlah');
            $table->string('satuan');
            $table->bigInteger('total');
         
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
        Schema::dropIfExists('delivery_order_details');
    }
}
