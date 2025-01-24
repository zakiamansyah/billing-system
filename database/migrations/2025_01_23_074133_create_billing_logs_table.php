<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('billing_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vps_id');
            $table->decimal('amount', 10, 2);
            $table->timestamp('timestamp')->useCurrent();

            $table->foreign('vps_id')->references('id')->on('vps')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('billing_logs');
    }
};
