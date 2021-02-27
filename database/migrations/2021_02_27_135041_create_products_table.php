<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE SEQUENCE IF NOT EXISTS product_sequence START 10001 MINVALUE 10001 MAXVALUE 99999 CYCLE');
        Schema::create('products', function (Blueprint $table) {
            $table->bigInteger('product_id')->primary();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->decimal('price', 22);
            $table->string('image', 255);
            $table->decimal('discount_percentage', 22)->nullable()->default(0.00);
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
        DB::statement('DROP SEQUENCE product_sequence');
        Schema::dropIfExists('products');
    }
}
