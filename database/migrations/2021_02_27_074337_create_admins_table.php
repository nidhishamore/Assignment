<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE SEQUENCE IF NOT EXISTS admin_sequence START 10001 MINVALUE 10001 MAXVALUE 99999 CYCLE');
        Schema::create('admins', function (Blueprint $table) {
            $table->bigInteger('admin_id')->primary();
            $table->string('name', 100);
            $table->string('email', 50)->unique();
            $table->string('password');
            $table->boolean('status');
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
        DB::statement('DROP SEQUENCE admin_sequence');
        Schema::dropIfExists('admins');
    }
}
