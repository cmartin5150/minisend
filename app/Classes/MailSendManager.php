<?php

namespace App\Classes;

class MailSendManager
{
    // the number of emails to attempt to send on each run
    const BATCH_SIZE = 5;
    
    // the maximum number of attempts to send an email
    const MAX_SEND_ATTEMPTS = 5;
    
    public static function processMailQueue()
    {   
        $emails_to_process = self::getEmailsToProcess();
        
        if(!empty($emails_to_process)) {
            foreach ($emails_to_process as $email) {
                self::processEmail($email);
            }
        }
    }
    
    private static function processEmail($email)
    {               
        // attempt to send email
        $success = self::sendEmail($email);
        
        $email->send_attempts++;
        
        if($success) {    
            $email->status_id = EmailStatus::SENT;
        } else {
            $email->status_id = EmailStatus::FAILED;
        }
                        
        $email->save();
    }
    
    private static function sendEmail($email)
    {
        $success = SendMailApiClient::sendEmail($email);
        
        return $success;
    }
    
    private static function getEmailsToProcess()
    {
        $emails_to_process = Email::whereIn('status_id', self::getEligibleStatuses());        
        $emails_to_process->where('send_attempts', '<', self::MAX_SEND_ATTEMPTS);
        
        // attempt to send oldest items first
        $emails_to_process->orderBy('id', 'ASC');
        
        // limit number of emails processed at a time
        $emails_to_process->limit(self::BATCH_SIZE);
        
        // return the emails
        return $emails_to_process->get();
    }
    
    private static function getEligibleStatuses()
    {
        $eligible_statuses = [];
        $eligible_statuses[] = EmailStatus::POSTED;
        $eligible_statuses[] = EmailStatus::FAILED;
        
        return $eligible_statuses;
    }
}