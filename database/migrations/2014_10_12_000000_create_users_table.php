<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('me')->unique();
            $table->text('token')->nullable();
            $table->string('scope')->nullable();
            $table->enum('method', ['html5', 'json'])->default('json');
            $table->text('micropub_endpoint')->nullable();
            $table->text('media_endpoint')->nullable();
            $table->text('syndication_targets')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
