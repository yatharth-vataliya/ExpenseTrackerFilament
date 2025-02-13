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
        Schema::create('transaction_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('CASCADE');
            $table->string('transaction_type_name')->index('transaction_types_transaction_type_name_index');
            $table->text('description')->nullable()->fulltext('transaction_types_description_fulltext');
            //$table->softDeletes();
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable();
            // $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            // $table->foreign('transaction_type_id')->references('id')->on('transactions')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_types');
    }
};
