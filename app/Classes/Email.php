<?php 

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table = 'emails';
    
    protected $fillable = [
        'from',
        'to',
        'subject',
        'content_plain',
        'content_html',
        'status_id'
    ];
    
    public function status()
    {
        return $this->hasOne(EmailStatus::class, 'status_id', 'status_id');
    }
    
    public function attachments()
    {
        return $this->hasMany(EmailAttachment::class, 'email_id', 'id');
    }
}