<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->decimal('montant', 10, 2);
        $table->string('reference')->unique();
        $table->string('pseudo')->nullable();
        $table->string('email');
        $table->string('prenom');
        $table->string('nom');
        $table->string('adresse');
        $table->string('ville');
        $table->string('code_postal');
        $table->string('pays');
        $table->string('telephone')->nullable();
        $table->string('shipping_method');
        $table->decimal('shipping_cost', 10, 2)->default(5.00);
        $table->decimal('total', 8, 2)->default(0);
        $table->enum('payment_method', ['apple_pay', 'paypal', 'visa']);
        $table->ipAddress('ip_address');
        $table->enum('payment_status', ['pending','paid'])->default('pending');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};