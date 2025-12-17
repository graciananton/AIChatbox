<?php
require_once "MailInterface.php";
class ContactMailService implements MailInterface{
    public function __construct(){
    }
    public function sendMessage(Contact $Contact):bool{
        $headers = $this->setHeader();
        if (mail($Contact->getEmailAddress(),"AI Chatbox",$Contact->getMessage()."\n From: ".$Contact->getFrom(),$headers,'-fnoreply@gracian.ca')){
            return true;
        }
        else{
            return false;
        }
    }   
    public function setHeader():array{
        $headers = Config::headers();

        $headers = "From: {$headers['from']}\r\n".
                "Reply-To: {$headers['reply_top']}\r\n".
                "MIME-Version: {$headers['mime_version']}\r\n".
                "Content-Type: {$headers['content_type']}; charset={$headers['charset']}\r\n";
        return $headers;
    }
}