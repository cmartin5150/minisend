<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Classes\EmailStatus;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('to');
            $table->string('from');
            $table->string('subject');
            $table->text('content_plain');
            $table->text('content_html');
            $table->smallInteger('status_id')->default(EmailStatus::POSTED);
            $table->integer('send_attempts')->default(0);
            
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
        Schema::dropIfExists('emails');
    }
}
