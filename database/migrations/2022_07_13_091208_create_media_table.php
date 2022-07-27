<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('type');
            $table->string('path');
            $table->timestamps();
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->foreign('pdf_id')->references('id')->on('media')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropForeign(['pdf_id']);
        });

        Schema::dropIfExists('photos');
        Schema::dropIfExists('files');
        Schema::dropIfExists('media');
    }
};
