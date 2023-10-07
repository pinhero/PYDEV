<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserConfirmationTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_confirmation_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('callback_url');
            $table->string('email')->index();
            $table->string('url');
            $table->dateTime('date_expiration');
            $table->string('token')->unique();
            $table->boolean('deja_utilise')->default(false);
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
        Schema::dropIfExists('user_confirmation_tokens');
    }
}
