<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHargaModalToBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('harga');
            $table->bigInteger('harga_modal')->after('nama');
            $table->bigInteger('harga_jual')->after('harga_modal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('harga_modal');
            $table->dropColumn('harga_jual');
            $table->bigInteger('harga');
        });
    }
}
