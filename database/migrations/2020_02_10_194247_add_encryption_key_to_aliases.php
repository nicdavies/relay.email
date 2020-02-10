<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEncryptionKeyToAliases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aliases', function (Blueprint $table) {
            $table
                ->unsignedBigInteger('encryption_key_id')
                ->nullable()
                ->index()
            ;

            $table
                ->foreign('encryption_key_id')
                ->references('id')
                ->on('pgp_keys')
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
        Schema::table('aliases', function (Blueprint $table) {
            $table->dropForeign(['encryption_key_id']);
            $table->dropColumn('encryption_key_id');
        });
    }
}
