<?php 

namespace App\Classes;

/**
 * 
 * Class to send emails via an API.
 * There is no API configured so this class simulates sending and returning a success status
 *
 */
class SendMailApiClient
{
    public static function sendEmail()
    {
        // placeholder function that could be connected to an API.
        // we expect that the API response would contain a success status.
        // since there is no API, we generate an example success status.
                
        return self::generateSuccessStatus();
    }
    
    /**
     * generates a success status.
     * @return boolean
     */
    private static function generateSuccessStatus()
    {
        // use to always return success == true
        $return_true = false;
        
        // use to always return success == false
        $return_false = false;
        
        if($return_true) {
            return true;
        }
        
        if($return_false) {
            return false;
        }
        
        // return a random succss status
        $min = 0;
        $max = 1;
        $success_threshold = 0;
        $value = rand($min, $max) ;
        
        if($value > $success_threshold) {
            return true;
        }
        
        return false;
    }
}