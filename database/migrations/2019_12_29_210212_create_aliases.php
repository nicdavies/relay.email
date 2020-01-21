<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAliases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aliases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('uuid', 20)->unique();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('alias', 20)->index();
            $table->string('name', 20);
            $table->timestamps();
            $table->softDeletes();
            
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aliases');
    }
}
