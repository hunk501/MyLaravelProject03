<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdlComelecsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tbl_comelec', function(Blueprint $table) {
            $table->increments('id');
            $table->string("voters_name");
            $table->string("voters_address");
            $table->date("bday");
            $table->string("baranggay");
            $table->string("city");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('tbl_comelec');
    }

}
