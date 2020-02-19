<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('identifiant_fiscal')->nullable();
            $table->string('registre_commerce')->nullable();
            $table->string('taxe_professionnelle')->nullable();
            $table->string('cnss')->nullable();
            $table->string('ice')->nullable();
            $table->string('nom_gerant')->nullable();
            $table->string('cin')->nullable();
            $table->string('phone')->nullable();
            $table->longText('adresse')->nullable();
            $table->string('num_fix')->nullable();
            $table->string('forme_juridique')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
