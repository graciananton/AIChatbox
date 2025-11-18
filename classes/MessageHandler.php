<?php
class MessageHandler{
    private object $Repository;
    private string $message;
    private string $uid;
    private string $chatId;
    private string $messageId;
    // private string $python_path = "C:\\Users\\basil\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
    //private string $python_path = "python3";
    //private string $index = "C:\\gracian\\DocuMind\\python\\index.py";
    //private string $index = "/homepages/3/d1017242952/htdocs/DocuMind/python/index.py";
    private string $python_path;
    private string $index;
    public function __construct(string $message, string $chatId, string $uid){
        $this->uid = $uid;
        $this->message = $message;
        $this->chatId = $chatId ?? "1";
        $this->setPythonBridgeValues();
    }
    public function setPythonBridgeValues(){
        if($_SERVER['HTTP_HOST'] == "localhost"){
            $this->python_path = "C:\\Users\\basil\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
            $this->index = "C:\\gracian\\DocuMind\\python\\index.py";
        }
        else{
            $this->python_path = "python3";
            $this->index = "/homepages/3/d1017242952/htdocs/DocuMind/python/index.py";
        }
    }
    public function getNewChatId(){
        $this->Repository = new UserRepository();
        return $this->Repository->getNewChatId($this->uid);
    }
    public function storeChat():string{
        $this->Repository = new UserRepository();
        $cmd = sprintf(
            '"%s" "%s" %s %s %s %s 2>&1',
            $this->python_path,
            $this->index,
            escapeshellarg($this->message),
            escapeshellarg($this->chatId),
            escapeshellarg($this->uid),
            "title"
        );
        $chat_title = shell_exec($cmd);
        $this->Repository->storeChat($this->chatId,$this->uid,$chat_title);
        return $chat_title;
    }
    public function storeAIReply(string $AIReply):bool{
        $this->Repository = new UserRepository();
        return $this->Repository->saveAIReply($this->messageId,$AIReply);
    }
    public function storeMessage():bool{
        $this->Repository = new UserRepository();
        return $this->Repository->saveMessage($this->message,$this->chatId,$this->uid);
    }
    public function getLatestMessageId():void{
        $this->Repository = new UserRepository();
        $messageId =  $this->Repository->getLatestMessageId($this->uid);
        $this->messageId = $messageId['msgId'];

    }
    public function chatExists():?array{
        $this->Repository = new UserRepository();
        return $this->Repository->chatExists($this->chatId,$this->uid);
    }
    public function generateResponse():string{
        $cmd = sprintf(
            '"%s" "%s" %s %s %s %s 2>&1',
            $this->python_path,
            $this->index,
            escapeshellarg($this->message),
            escapeshellarg($this->chatId),
            escapeshellarg($this->uid),
            "reply"
        );

        $output = shell_exec($cmd);
        return $output;
    }

    public function loadMessages():array{
        $this->Repository = new UserRepository();
        return $this->Repository->loadMessages($this->chatId,$this->uid);
    }
    public function loadChats():array{
        $this->Repository = new UserRepository();
        return $this->Repository->loadChats($this->uid);
    }
}

