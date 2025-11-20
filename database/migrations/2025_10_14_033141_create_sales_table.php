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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->string('payment_type')->nullable();
            $table->integer('due_days')->nullable();
            $table->date('due_date')->nullable();
            $table->string('customer_code');
            $table->string('customer_name');
            $table->string('customer_address')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_nik')->nullable();
            $table->string('customer_npwp')->nullable();
            $table->string('salesman_name')->nullable();
            $table->float('ppn', 10,2)->default(0);
            $table->double('discount', 8, 2)->default(0);
            $table->decimal('total_discount', 15, 2)->default(0);
            $table->decimal('total_price', 15, 2);
            $table->integer('total_quantity')->default(0);
            $table->string('notes')->nullable();
            $table->string('confirm_status')->default('HOLD');
            $table->string('confirm_by')->nullable();
            $table->timestamp('confirm_at')->nullable();
            $table->string('confirm_notes')->nullable();
            $table->string('confirm_location')->nullable();
            $table->integer('source_id')->nullable();
            $table->string('brand')->nullable();
            $table->string('cabang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
