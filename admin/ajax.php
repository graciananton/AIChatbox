<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $files = array_diff(scandir("../classes"), array('.', '..'));

    foreach ($files as $file) {
        require_once "../classes/{$file}";
    }

    if(isset($_REQUEST["message"]) && isset($_REQUEST["chatId"]) && isset($_REQUEST['uid'])){
            $MessageHandler = new MessageHandler($_REQUEST['message'],$_REQUEST['chatId'],$_REQUEST['uid']);
            $chat_title = "";
            if($MessageHandler->chatExists() == null){
                $chat_title = $MessageHandler->storeChat();
            }

            $MessageHandler->storeMessage();

            $MessageHandler->getLatestMessageId();
            
            $AIReply = $MessageHandler->generateResponse();
            $MessageHandler->storeAIReply($AIReply);

            echo json_encode([$chat_title,$AIReply]);
    }
    else if(array_key_exists("emailaddress",$_REQUEST)){
        $UserRepository = new UserRepository();
        $result = $UserRepository->deleteAccount($_REQUEST['emailaddress']);
        echo $result;
    }
