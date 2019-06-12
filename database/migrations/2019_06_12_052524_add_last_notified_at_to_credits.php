<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLastNotifiedAtToCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function($table){
            $table->dateTime('last_notified_at')
                ->default(date('Y-m-d H:i:s', strtotime('0000-00-00 00:00:00')))
                ->after('last_payment_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credits', function($table){
            $table->dropColumn('last_notified_at');
        });
    }
}
