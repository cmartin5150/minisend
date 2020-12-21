<?php 

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class EmailAttachment extends Model
{
    protected $table = 'email_attachments';
    
    protected $fillable = [
        'email_id',
        'data',
        'name',
        'mime_type',
        'size'
    ];
}