<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatNegatifsTable extends Migration
{
    public function up()
    {
        Schema::create('certificat_negatifs', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
