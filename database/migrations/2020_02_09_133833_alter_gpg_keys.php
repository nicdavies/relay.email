<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGpgKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('gpg_keys', 'pgp_keys');
        Schema::table('pgp_keys', function (Blueprint $table) {
            $table->renameColumn('gpg_key', 'public_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('pgp_keys', 'gpg_keys');
        Schema::table('gpg_keys', function (Blueprint $table) {
            $table->renameColumn('public_key', 'gpg_key');
        });
    }
}
