<?php
require_once "MailInterface.php";
class ContactMailService implements MailInterface{
    public function __construct(){
    }
    public function sendMessage(Contact $Contact):bool{
        $headers = "From: noreply@gracian.ca\r\n".
                "Reply-To: noreply@gracian.ca\r\n".
                "MIME-Version: 1.0\r\n".
                "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail("basil_anton@yahoo.ca","AI Chatbox",$Contact->getMessage()."<br/><br/><br/>".$Contact->getEmailAddress(),$headers,'-fnoreply@gracian.ca')){
            return true;
        }
        else{
            return false;
        }
    }   
}