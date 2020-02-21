<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEncryptionKeyToAliasMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alias_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('encryption_key_id')->nullable();

            $table
                ->foreign('encryption_key_id')
                ->references('id')
                ->on('encryption_keys')
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
        Schema::table('alias_messages', function (Blueprint $table) {
            //
        });
    }
}
