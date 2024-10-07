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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->unique();
            $table->integer('quantity')->default(0)->comment('Product stock quantity');
            $table->integer('buying_price')->comment('Buying Price');
            $table->integer('selling_price')->comment('Selling Price');
            $table->integer('quantity_alert')->default(1);
            $table->integer('tax')->nullable();
            $table->tinyInteger('tax_type')->nullable();
            $table->text('notes')->nullable();
            $table->string('product_image')->nullable();

            $table->foreignId('category_id')->constrained()->onDelete('cascade');


            $table->foreignId('unit_id')->constrained()->onDelete('cascade');

            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');

            $table->softDeletes();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
