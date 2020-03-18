<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAliasMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alias_messages', function (Blueprint $table) {
            $table->dropForeign(['encryption_key_id']);
            $table->dropColumn([
                'from',
                'sender',
                'encryption_key_id',
                'token',
                'signature',
            ]);

            $table->string('message_id');
            $table->string('from_email');
            $table->string('from_name');

            $table->unsignedInteger('spam_score')->nullable();
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

        });
    }
}
