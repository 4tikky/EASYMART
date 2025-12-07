<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('storeName');
            $table->text('storeDescription')->nullable();
            $table->string('picName');
            $table->string('picPhone');
            $table->string('picEmail')->nullable();
            $table->string('picStreet');
            $table->string('picRT')->nullable();
            $table->string('picRW')->nullable();
            $table->string('picVillage')->nullable();
            $table->string('picCity');
            $table->string('picProvince');
            $table->string('picKtpNumber');
            $table->string('picPhotoPath')->nullable();
            $table->string('picKtpFilePath')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sellers');
    }
};
