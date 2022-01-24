<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizTemporaryFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_temporary_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('set_kuis_id');
            $table->foreignId('kuis_id');
            $table->foreignId('soal_id');
            $table->foreignId('user_id');
            $table->string('folder');
            $table->string('filename');
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
        Schema::dropIfExists('quiz_temporary_files');
    }
}
