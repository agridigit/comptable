<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorisationDactivitesTable extends Migration
{
    public function up()
    {
        Schema::create('autorisation_dactivites', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
