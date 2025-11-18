<?php
class HomeController extends Controller{
    private HomeView $View;
    public function __construct(array $request){
        print_r($request);
        parent::__construct($request);
        $this->View = new HomeView($request);
    }
    public function process():void{
        switch($this->req){
            case $this->req == "home":
                echo "home";
                $this->View->process();
            case $this->req == "submit":
                $Validation = new Validation();
                $errors = $Validation->verifyEmail($this->request);
                if(count($errors)==0){
                   $Contact = new Contact($this->request);
                   $ContactMailService = new ContactMailService($Contact);
                   if($ContactMailService->sendMessage($Contact)){
                     $this->request = [];
                     $this->request['req'] = "home";
                     $this->request['success'] = true;
                     $this->View = new HomeView($this->request);
                     $this->View->process();
                   }
                   else{
                        $this->request = [];

                        $this->request['errors'] = $errors;
                        $this->request['req'] = "home";
                        $this->request['success'] = false;
                        $this->View = new HomeView($this->request);
                        $this->View->process();
                     // return back form with errors
                   }
                }
                else{
                    $this->request = [];
                    $this->request['errors'] = $errors;
                    $this->request['req'] = "home";
                    $this->request['success'] = false;
                    $this->View = new HomeView($this->request);
                    $this->View->process();

                    // return back form with errors
                }
        }
    }
}