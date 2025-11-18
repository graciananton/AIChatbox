<?php
class DashboardController extends Controller{
    private MessageHandler $MessageHandler;
    public function __construct(array $request){
        parent::__construct($request);
    }
    public function process():void{
        if($this->req == "basic"){
                $this->MessageHandler = new MessageHandler("",$this->request['chatId'],$this->request['uid']);    
                $messages = $this->MessageHandler->loadMessages();
                $chats = $this->MessageHandler->loadChats();
                $newChatId = $this->MessageHandler->getNewChatId();
                $this->request['newChatId'] = $newChatId;
                $this->request['chats'] = $chats;
                $this->request['msgs'] = $messages;
                $View = new DashboardView($this->request);
                $View->setNavBar();
                $View->process();
        }
       
    }
    
}