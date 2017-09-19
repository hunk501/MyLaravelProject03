<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMdlApplicationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('tbl_application', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string("image_path", 255);
                $table->string("branch", 255);
                $table->string("pnno", 255);
                $table->string("type", 255);
                $table->string("borrower_name", 255);
                $table->string("borrower_address");
                $table->string("character_url", 255);
                $table->string("tel_no", 255);
                $table->date("bday");
                $table->string("spouse", 255);
                $table->string("tin", 255);
                $table->string("sss", 255);
                $table->string("email_address", 255);
                $table->string("business_name", 255);
                $table->string("business_contact", 255);
                $table->string("business_address");
                $table->string("comaker", 255);
                $table->string("comaker_contact", 255);
                $table->string("comaker_social_media");
                $table->string("comaker_address");
                $table->string("co_borrower", 255);
                $table->string("co_borrower_address");
                $table->string("co_borrower_contact", 255);
                $table->string("character_reference", 255);
                $table->string("character_contact", 255);
                $table->string("reference_address", 255);
                $table->string("reference_url");
                $table->string("relation", 255);
                $table->date("date_entered");
                $table->string("encoder", 255);
                $table->timestamps();
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('tbl_application');
	}

}
