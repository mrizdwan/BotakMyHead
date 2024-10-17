<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCainfosTable extends Migration
{
    public function up()
    {
        Schema::create('cainfos', function (Blueprint $table) {
            $table->id();
            $table->string('cacode')->unique();
            $table->string('email');
            $table->string('phone');
            $table->string('plan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cainfos');
    }
}
