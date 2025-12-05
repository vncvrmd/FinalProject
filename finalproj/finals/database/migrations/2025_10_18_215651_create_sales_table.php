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
        $table->id('sales_id');
        $table->foreignId('customer_id')->constrained('customers', 'customer_id')->onDelete('cascade');
        $table->decimal('total_amount', 10, 2)->default(0);
        $table->string('payment_method');
        $table->timestamp('sales_date');
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
