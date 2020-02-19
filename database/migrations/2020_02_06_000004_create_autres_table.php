<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutresTable extends Migration
{
    public function up()
    {
        Schema::create('autres', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
