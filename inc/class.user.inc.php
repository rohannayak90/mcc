<?php

class User
{
    public $name = '';
    public $email = '';
    public $login_username = '';
    public $login_password = '';
    
    private $api_key = '23435345';
    
    public function __construct()
    {
        
    }
    
    public function createAccount()
    {
        //return $this->email;
        
        $data = [];
        $data['name'] = $this->name;
        $data['email'] = $this->email;
        $data['username'] = $this->login_username;
        $data['password'] = $this->login_password;
        echo ($this->sendVerificationMail());return;
        $result = CallAPI('POST', 'register', $data);
        $result_array = json_decode($result);
        
        if (isset($result_array->error) && $result_array->error == 1)
        {
            //die('Error Occured - ' . $result_array->message);
            $message = $result_array->message;
        }
        else
        {
            $message = $result;
            //echo $result_array->message;
            //header('Location: ' . base_url() . 'pages/dashboard.php');
            echo ($this->sendVerificationMail());
        }
        return $result;
    }
    
    private function sendVerificationMail()
    {
        //$e = sha1(email); // For verification purposes
        $to = 'murari.mnayak@webspiders.com';//trim(email);
        $url_verification = base_url() . 'pages/verify-account.php?email=' . $to . '&v=' . $this->api_key;
 
        $subject = "[Colored Lists] Please Verify Your Account";
 
        $headers = '<<<MESSAGE
                    From: Colored Lists <donotreply@coloredlists.com>
                    Content-Type: text/plain;
                    MESSAGE';

        $msg = '<<<EMAIL
                You have a new account at Colored Lists!
 
                To get started, please activate your account and choose a password by following the link below.
                
                Your Username: $to
                
                Activate your account: $url_verification
                
                If you have any questions, please contact help@coloredlists.com.
                
                --
                
                Thanks!
                
                Creative
                www.creative.com
                EMAIL';
                
        return mail($to, $subject, $msg, $headers);    
    }
}

?>