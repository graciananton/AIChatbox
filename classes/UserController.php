<?php
class UserController extends Controller{
    public function __construct(array $request){
        parent::__construct($request);
    }
    public function process():void{
        switch($this->req){
            case "signup":
                $View = new UserView($this->request);
                $View->process();
                break;
            case "login":
                $View = new UserView($this->request);
                $View->process();
                break;
            case "submit_signup":
                //$password_hash = $this->request['password_hash'];
                
                $UserRepository = new UserRepository();
                $result = $UserRepository->checkDuplicateEmail($this->request['emailaddress']);
                
                if($result == null){
                    $Contact = new Contact();

                    $verification_code = rand(100000,600000);
                    $expires_at = date('Y-m-d H:i:s', time() + 900); 
                     

                    $result = $UserRepository->insertCode($this->request['emailaddress'],$verification_code,date('Y-m-d H:i:s'),$expires_at,false);

                    $subject = "DocuMind Verification Code";
                    $body = "Your verification code is $verification_code";
                    
                    $headers = "From: noreply@gracian.ca\r\n".
                    "Reply-To: noreply@gracian.ca\r\n".
                    "MIME-Version: 1.0\r\n".
                    "Content-Type: text/plain; charset=UTF-8\r\n";

                    $result = $Contact->sendMail($this->request['emailaddress'],$subject,$body,$headers);
                    if($result){
                        $this->request['result'] = $result;
                        $this->request['req'] = "verification_code_signup";
                        $this->request['emailaddress'] = $this->request['emailaddress'];
                        $this->request['password_hash'] = $this->request['password_hash'];
                        $View = new UserView($this->request);
                        $View->process();
                    }
                }
                else{
                    $this->request['error'] = true;
                    $this->request['req'] = "signup";
                    $View = new UserView($this->request);
                    $View->process();
                    break;
                }
                break;
            case "verification_code_submit":
                  $Validation = new Validation();
                  if($Validation->verifyVerificationCode($this->request['emailaddress'],[$this->request['verification_code1'],$this->request['verification_code2'],$this->request['verification_code3'],$this->request['verification_code4'],$this->request['verification_code5'],$this->request['verification_code6']])){
                    $UserRepository = new UserRepository();
                    $result = $UserRepository->saveLoginCredentials($this->request['emailaddress'],$this->request['password_hash']); 
                    if($result){
                        $this->request['req'] = "verification_code_success";
                        $result = $UserRepository->verifyCode(
                            $this->request['emailaddress'],
                            (string)(
                                $this->request['verification_code1'] .
                                $this->request['verification_code2'] .
                                $this->request['verification_code3'] .
                                $this->request['verification_code4'] .
                                $this->request['verification_code5'] .
                                $this->request['verification_code6']
                            )
                        );                        
                        $View = new UserView($this->request);
                        $View->process();
                    }
                  }
                  else{
                    $request = [];
                    $request['req'] = "verification_code_error";
                    $View = new UserView($request);
                    $View->process();
                  }
                break;
            case "submit_login":
                $_SESSION['emailaddress'] = $this->request['emailaddress'];
                $_SESSION['password_hash'] = $this->request['password_hash'];

                $UserRepository = new UserRepository();
                $user = $UserRepository->findByLoginCredentials($_SESSION['emailaddress'],$_SESSION['password_hash']);
                if($user == null){
                    $this->request = [];
                    $this->request['error'] = true;
                    $this->request['req'] = "login";
                    $View = new UserView($this->request);
                    $View->process();
                }
                else if(is_array($user)){
                    $Repository = new UserRepository();
                    $uid = $Repository->getUid($_SESSION['emailaddress'], $_SESSION['password_hash']);
                    $_SESSION['uid'] = $uid['uid'];
                    echo "<script>window.location.href='index.php?chatId=1';</script>";
                }
        }
    }
}