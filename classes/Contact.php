<?php
class Contact{
    private string $emailaddress;
    private string $password;
    private string $fullname;
    private array $request;
    private string $message;
    private string $from;
    public function __construct(array $request){
        $this->request = $request;
        $this->emailaddress = $request['emailaddress'] ?? "";
        $this->password = $request['password'] ?? "";
        $this->fullname = $request['fullname'] ?? "";
        $this->message = $request['message'];
        $this->from = $request['from'] ?? "";
    }
    public function getRequest():array{
        return $this->request;
    }
    public function getFrom():string{
        return $this->from;
    }
    public function getMessage():string{
        return $this->message;
    }
    public function getEmailAddress():string{
        return $this->emailaddress;
    }
    public function getFullName():string{
        return $this->fullname;
    }
    public function getPassword():string{
        return $this->password;
    }
}