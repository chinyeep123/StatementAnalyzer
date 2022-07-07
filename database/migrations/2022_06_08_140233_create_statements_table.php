<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statements', function (Blueprint $table) {
            $table->id();
            $table->string('importid')->nullable()->index();
            $table->string('account_number')->nullable()->index();
            $table->date('date')->nullable()->index();
            $table->text('description')->nullable();
            $table->string('debit_currency')->nullable()->index();
            $table->decimal('debit', 10)->default(0)->index();
            $table->string('credit_currency')->nullable()->index();
            $table->decimal('credit', 10)->default(0)->index();
            $table->string('balance_currency')->nullable()->index();
            $table->decimal('balance', 10)->default(0)->index();
            $table->softDeletes();
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
        Schema::dropIfExists('statements');
    }
}
