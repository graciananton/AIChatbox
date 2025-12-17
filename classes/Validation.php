<?php
class Validation{
    private UserRepository $UserRepository;
    public function __construct(){
        $this->UserRepository = new UserRepository();
    }
    public function verifyEmail(array $request){
        $recaptchaSecret = Config::recaptchaSecret();
        $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptchaResponse = $this->request['g-recaptcha-response'] ?? '';
        $errors = [];
        $response = file_get_contents($verifyURL . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
        $recaptchaResponse = $request['g-recaptcha-response'] ?? '';
        if (empty($recaptchaResponse)) {
                $errors[] = 'g-recaptcha-response';
        } else {
                $response = file_get_contents($verifyURL . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
                $responseData = json_decode($response, true);
                if (isset($responseData['success']) && $responseData['success'] === true) {
                    $errors[] = 'g-recaptcha-response';
                } 
        }
                    foreach($request as $key=>$value){
                        
                        if($key != "g-recaptcha-response"){
                            $pattern = '/^[A-Za-z0-9\s.,!?\'":;@_\-]+$/';
                            if (!preg_match($pattern, $key) || !preg_match($pattern, $value)) {
                                $errors[] = $key;
                            }
                        }
                    }

        return $errors;

    }
    public function verifyVerificationCode(string $emailaddress,array $verification_code):bool{
        $verification_code = implode("",$verification_code);
        $code = $this->UserRepository->getCodeByEmailAddress($emailaddress,$verification_code);
        if(is_array($code) && count($code) >= 1){
            return true;
        }
        else{
            return false;
        }
    }
}