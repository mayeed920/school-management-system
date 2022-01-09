<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClasessesTable extends Migration
{
    public function up()
    {
        Schema::create('clasesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class_name');
            $table->timestamps();
        });
    }
}
