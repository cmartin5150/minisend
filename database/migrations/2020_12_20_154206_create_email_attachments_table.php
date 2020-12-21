<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_attachments', function (Blueprint $table) {
            $table->increments('id');
            
            $table->bigInteger('email_id');
            $table->string('name');
            $table->string('mime_type');
            $table->integer('size');
            
            $table->timestamps();
        });
        
        // eloquent does not support MEDIUMBLOB (supporting attachments up to 16 Mb)
        DB::statement('ALTER TABLE `email_attachments` ADD `data` MEDIUMBLOB AFTER `name`;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_attachments');
    }
}
