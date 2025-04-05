<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('task_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('event_type', ['created', 'updated', 'deleted', 'status_changed']);
            $table->json('changes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_histories');
    }
}; 