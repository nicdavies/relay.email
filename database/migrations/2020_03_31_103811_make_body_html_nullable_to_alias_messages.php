<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeBodyHtmlNullableToAliasMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alias_messages', function (Blueprint $table) {
            $table->longText('body_html')->nullable()->change();
            $table->longText('body_plain')->nullable()->change();
        });
    }

    /**z
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alias_messages', function (Blueprint $table) {
            $table->longText('body_html')->nullable(false)->change();
            $table->longText('body_plain')->nullable(false)->change();
        });
    }
}
