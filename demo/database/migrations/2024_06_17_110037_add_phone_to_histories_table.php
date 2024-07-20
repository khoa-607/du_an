<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneToHistoriesTable extends Migration
{
    public function up()
    {
        Schema::table('histories', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('histories', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
}
