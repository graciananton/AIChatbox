<?php
class UserRepository extends Repository{
    public function __construct(){
        parent::__construct();
    }
    public function deleteAccount(string $emailaddress){
        $sql = $this->QueryBuilder->deleteAccount();
        return $this->DatabaseManager->execute(
            $sql,
            $params = [
                'email_address' => $emailaddress
            ]
        );
    }
    public function verifyCode(string $emailaddress,string $verification_code){
        $sql = $this->QueryBuilder->verifyCode();
        return $this->DatabaseManager->execute(
            $sql,
            $params = [
                "email_address" => $emailaddress,
                "verification_code"=>$verification_code
            ]
        );
    }
    public function getCodeByEmailAddress($emailaddress,$verification_code){
        $sql = $this->QueryBuilder->getCodeByEmailAddress();
        return $this->DatabaseManager->fetchOne(
            $sql,
            $params = [
                "email_address"=>$emailaddress,
                "verification_code"=>$verification_code,
                'email_address_sub'=>$emailaddress
            ]
        );
    }
    public function insertCode(string $emailaddress,string $verification_code,string $created_at,string $expires_at,bool $verified):bool{
        $sql = $this->QueryBuilder->insertCode();
        return $this->DatabaseManager->execute(
            $sql,
            $params = [
                'email_address'=> $emailaddress,
                'verification_code' => $verification_code,
                'created_at' => $created_at,
                'expires_at' => $expires_at,
                'verified' => false
            ]
        );
    }
    public function storeCode(string $emailaddress,string $code){
        $sql = $this->QueryBuilder->storeCode($email,$code);
        return $this->DatabaseManager->execute
        (
            $sql,
            $params = [
                ':email_address' => $emailaddress,
                ':code' => $code
            ]
        );
    }
    public function checkDuplicateEmail(string $emailaddress){
        $sql = $this->QueryBuilder->checkDuplicateEmail();
        return $this->DatabaseManager->fetchOne($sql,
        $params=[
            ':email_address' => $emailaddress
        ]
        );
    }
    public function getUid(string $emailaddress, string $password_hash){
        $sql = $this->QueryBuilder->getUid();
        return $this->DatabaseManager->fetchOne($sql,$params=[
            ':email_address'=>$emailaddress,
            ':password_hash' => $password_hash
        ]);
    }
    public function getNewChatId(string $uid){
        $sql = $this->QueryBuilder->getNewChatId();
        return $this->DatabaseManager->fetchOne($sql,$params=[
            ':uid' => $uid
        ]);
    }
    public function storeChat(string $chatId,string $uid,string $title){
        $sql = $this->QueryBuilder->storeChat(); 
        return $this->DatabaseManager->execute($sql, $params = [
            ':chatId' => $chatId,
            ':uid' => $uid,
            ':title' => $title,
            ':createdAt' => date("Y-m-d")
        ]);
    }
    public function chatExists(string $chatId, string $uid):?array{
        $sql = $this->QueryBuilder->chatExists();
        return $this->DatabaseManager->fetchOne($sql,$params = [
                ':chatId'=> $chatId,
                ':uid' => $uid
            ]
        );
    }
    
    public function saveAIReply(string $messageId,string $AIReply):bool{
        $sql = $this->QueryBuilder->saveAIReply($messageId,$AIReply);
        return $this->DatabaseManager->execute($sql,$params = [
            ':msgId' => $messageId,
            ':AIReply' => $AIReply
        ]);
    }
    public function getLatestMessageId(string $uid):array{
        $sql = $this->QueryBuilder->getLatestMessageId();
        return $this->DatabaseManager->fetchOne($sql,$params=[
            ':uid' => $uid
        ]);
    }
    public function saveLoginCredentials(string $email_address,string $password_hash):bool{
        $sql = $this->QueryBuilder->saveLoginCredentials($email_address,$password_hash);
        return $this->DatabaseManager->execute($sql,$params=[
            ':email_address' => $email_address,
            ':password_hash' => $password_hash
        ]);
    }
    public function loadChats(string $uid):array{
        $sql = $this->QueryBuilder->loadChats();
        return $this->DatabaseManager->fetchAll($sql,$params=[
            ':uid' => $uid
        ]);
    }
    public function loadMessages($chatId,$uid){
        $sql = $this->QueryBuilder->loadMessages();
        return $this->DatabaseManager->fetchAll(
            $sql,[
                ':chatId' => $chatId,
                ':uid' => $uid
            ]
        );
    }
    public function saveMessage(string $message, string $chatId, string $uid):bool{
        $sql = $this->QueryBuilder->saveMessage();
        return $this->DatabaseManager->execute($sql,[
            ':msg' => $message,
            ':chatId' => $chatId,
            ':uid' => $uid,
            ':createdAt' => date("Y-m-d")
        ]);
    }
    public function findByLoginCredentials(string $email_address,string $password_hash):?array{
        $sql = $this->QueryBuilder->findByLoginCredentials();
        return $this->DatabaseManager->fetchOne(
            $sql,
            [
            ':email_address'=>$email_address,
            ':password_hash'=>$password_hash
            ]
        );
    }
}