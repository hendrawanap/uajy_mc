<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAksesKuisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akses_kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_kuis_id');
            $table->foreignId('kuis_id');
            $table->foreignId('soal_id');
            $table->foreignId('user_id');
            $table->string('jawaban')->nullable();
            $table->string('type');
            $table->boolean('isTrue')->default(0);
            $table->boolean('isFalse')->default(0);
            $table->boolean('isRagu')->default(0);
            $table->boolean('isCheck')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akses_kuis');
    }
}
