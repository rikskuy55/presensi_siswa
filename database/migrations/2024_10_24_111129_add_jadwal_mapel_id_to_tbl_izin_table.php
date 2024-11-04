<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJadwalMapelIdToTblIzinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_izin', function (Blueprint $table) {
            $table->foreignId('jadwal_mapel_id')->nullable()->constrained('tbl_jadwal_mapel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_izin', function (Blueprint $table) {
            $table->dropForeign(['jadwal_mapel_id']);
            $table->dropColumn('jadwal_mapel_id');
        });
    }
}
