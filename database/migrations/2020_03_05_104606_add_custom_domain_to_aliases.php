<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomDomainToAliases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aliases', function (Blueprint $table) {
            $table->unsignedBigInteger('custom_domain_id')->nullable()->index();

            $table
                ->foreign('custom_domain_id')
                ->references('id')
                ->on('custom_domains')
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
            $table->dropIndex(['custom_domain_id']);
            $table->dropForeign(['custom_domain_id']);
            $table->dropColumn('custom_domain_id');
        });
    }
}
