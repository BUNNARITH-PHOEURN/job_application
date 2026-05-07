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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
             $table->string('title');
            $table->date('startdate');
            $table->date('enddate'); 
            $table->integer('post'); 
            $table->text('jr');             
            $table->text('jd');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
