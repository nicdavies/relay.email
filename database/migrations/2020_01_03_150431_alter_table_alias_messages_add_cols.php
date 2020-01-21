<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAliasMessagesAddCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alias_messages', function (Blueprint $table) {
            $table->dropColumn('body');
            $table->string('from');
            $table->string('sender');
            $table->longText('body_html');
            $table->longText('body_plain');
            $table->unsignedInteger('attachment_count')->default(0);
            $table->json('properties')->nullable();
            $table->json('raw_payload')->nullable();
            $table->string('token')->nullable();
            $table->string('signature')->nullable();
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
