<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('created_by_id')->constrained('users')->onDelete('RESTRICT');
            $table->foreignId('edited_by_id')->nullable()->constrained('users')->onDelete('SET NULL');
            $table->string('name', 30)->unique();
            $table->text('description');
            $table->string('pdf_path')->nullable();
            $table->timestamps();

//            $table->foreign('created_by_id')->references('íd')->on('users');
//            $table->foreign('edited_by_id')->references('íd')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
};
