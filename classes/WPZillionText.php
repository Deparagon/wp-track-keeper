<?php
/*
 SMSpress API.....
*/

 class WPZillionText
 {
     const SINGLEDAPI_URL = 'https://zilliontext.com.ng/index.php';
     const BULKAPI_URL = 'https://zilliontext.com.ng/index.php';
     const BALAPI_URL = 'https://zilliontext.com.ng/index.php';
     public $susername;
     public $spassword;
     public $sender;
     public $mobile;
     public $messagedata;

     public function __construct()
     {
         $this->susername = get_option('tk_cron_set_sms_username');
         $this->spassword = get_option('tk_cron_set_sms_password');
     }

     public function doHTTPRequest($base_url, $strings)
     {
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $base_url);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $strings);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         $base_response = curl_exec($ch);
         curl_close($ch);

         return $base_response;
     }
     



     public function send( $message )
     {
         $mobile = get_option('tk_cron_set_sms_number');
         $sender = get_option('tk_cron_set_sms_sender');
         if(!$mobile || !$sender){
            return;
         }
         $this->sendMessage($mobile, $message, $sender);
     }

     public function sendMessage($mobile, $messagedata, $sender)
     {

         try {
             $data_string = 'spapiusername='.urlencode($this->susername).'&password='.urlencode($this->spassword).'&countrycode=All&smstype=0&sender='.urlencode($sender).'&messagetext='.urlencode($messagedata).'&messagenumber='.urlencode($mobile).'&action=sms';

    
        $this->doHTTPRequest(self::SINGLEDAPI_URL, $data_string);


         } catch (Exception $e) {
             echo 'error occured with connection';
             exit;
         }

         return true;
     }


    public function checkbalance()
    {
        $data_string = 'spapiusername='.urlencode($this->susername).'&password='.urlencode($this->spassword).'&action=bal';

        $portresponse = $this->doHTTPRequest(self::BALAPI_URL, $data_string);
        if (stripos($portresponse, ':')) {
            $args = explode(':', $portresponse);

            return array_pop($args);
        }

        return $portresponse;
    }


 }