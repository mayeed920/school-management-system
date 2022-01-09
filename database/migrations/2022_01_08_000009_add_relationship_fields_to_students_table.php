<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('class_iid_id')->nullable();
            $table->foreign('class_iid_id', 'class_iid_fk_5753487')->references('id')->on('clasesses');
            $table->unsignedBigInteger('country_code_id')->nullable();
            $table->foreign('country_code_id', 'country_code_fk_5753488')->references('id')->on('countries');
        });
    }
}
