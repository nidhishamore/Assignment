<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE SEQUENCE IF NOT EXISTS customer_sequence START 10001 MINVALUE 10001 MAXVALUE 99999 CYCLE');
        Schema::create('customers', function (Blueprint $table) {
            $table->bigInteger('customer_id')->primary();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 50)->unique();
            $table->string('contact_number', 50);
            $table->string('password');
            $table->boolean('status');
            $table->string('role', 15)->default('customer');
            $table->rememberToken();
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
        DB::statement('DROP SEQUENCE customer_sequence');
        Schema::dropIfExists('customers');
    }
}
