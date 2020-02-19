<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapprochementBancairesTable extends Migration
{
    public function up()
    {
        Schema::create('rapprochement_bancaires', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('note')->nullable();
            $table->date('du')->nullable();
            $table->date('au')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
