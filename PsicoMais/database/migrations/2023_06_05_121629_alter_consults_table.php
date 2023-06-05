<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterConsultsTable extends Migration
{
    public function up()
    {
        Schema::table('consults', function (Blueprint $table) {
            $table->datetime('date')->change();
        });
    }

    public function down()
    {
        Schema::table('consults', function (Blueprint $table) {
            $table->time('date')->change();
        });
    }
}
