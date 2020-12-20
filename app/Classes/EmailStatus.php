<?php 

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class EmailStatus extends Model
{
    // assuming that POSTED means a send email request has been posted into the system
    const POSTED = 1;
    
    // assuming that SENT means the email has been successfully sent
    const SENT = 2;
    
    // the email send attempt failed
    const FAILED = 3;
    
    protected $table = 'email_statuses';
    public $timestamps = false;
}