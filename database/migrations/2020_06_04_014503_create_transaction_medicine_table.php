<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionMedicineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_medicine', function (Blueprint $table) {
            $table->id();

            $table->foreignId('transaction_id')
                ->references('id')->on('transactions')
                ->onDelete('cascade')->onUpdate("cascade");

            $table->foreignId('medicine_id')
                ->references('id')->on('medicines')
                ->onDelete('cascade')->onUpdate("cascade");

            $table->integer('stock')->default(0);
            $table->integer('price')->default(0);

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
        Schema::dropIfExists('transaction_medicine');
    }
}
