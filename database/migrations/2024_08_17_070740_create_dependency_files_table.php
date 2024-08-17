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
        Schema::create('dependency_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('file');
            $table->integer('status')->default(0);
            $table->json('upload_response')->nullable();
            $table->json('status_response')->nullable();
            $table->timestamps();

            $table->foreign('user_id','dependency_files_user_foregin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependency_files');
    }
};
