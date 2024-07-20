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
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); 
            $table->text('cmt'); 
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_blogs'); 
            $table->string('avatar_user'); 
            $table->string('name_user'); 
            $table->unsignedInteger('level')
                      ->default(0)->comment = 'cha:0 con:id_cha'; 
            $table->timestamp('time'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
