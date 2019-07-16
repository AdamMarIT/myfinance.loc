<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultingTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resulting_taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tax_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('created_by')->unsigned();
            $table->decimal('amount', 8, 2);
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resulting_taxes');
    }
}
