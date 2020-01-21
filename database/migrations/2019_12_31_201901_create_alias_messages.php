<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAliasMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alias_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('uuid', 20)->unique();
            $table->unsignedBigInteger('alias_id')->index();
            $table->string('subject');
            $table->string('body');
            $table->timestamps();
            $table->softDeletes();
            
            $table
                ->foreign('alias_id')
                ->references('id')
                ->on('aliases')
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
        Schema::dropIfExists('alias_messages');
    }
}
