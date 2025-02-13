<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('transaction_type_id')->constrained()->onDelete('CASCADE');
            $table->text('description')->nullable()->fulltext('transactions_description_fulltext');
            $table->string('item_unit')->nullable();
            $table->integer('item_count');
            $table->integer('item_price');
            $table->bigInteger('total')->storedAs('(item_count / 100 * item_price / 100) * 100');
            $table->date('transaction_date')->index('transactions_transaction_date_index');
            //$table->softDeletes();
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable();
            // $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            // $table->foreign('transaction_type_id')->references('id')->on('transaction_types')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
