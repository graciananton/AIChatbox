<?php
class QueryBuilder{
    public function __construct(){
  
    }
    public function verifyCode():string{
        return "UPDATE codes SET verified = 1 WHERE email_address = :email_address AND verification_code = :verification_code";

    }
    public function deleteAccount():string{
        return "DELETE users, messages, chats
                FROM users
                LEFT JOIN messages ON users.uid = messages.uid
                LEFT JOIN chats ON users.uid = chats.uid
                WHERE users.email_address = :email_address;";
    }
    public function getCodeByEmailAddress():string{
        return "SELECT *
            FROM codes c
            WHERE NOW() < c.expires_at
            AND email_address = :email_address
            AND verified = 0
            AND verification_code = :verification_code
            AND c.created_at = (
                SELECT MAX(created_at)
                FROM codes
                WHERE email_address = :email_address_sub
            )
            LIMIT 1";
    }
    public function getUid():string{
        return "SELECT uid FROM users WHERE email_address = :email_address AND password_hash = :password_hash";
    }
    public function getNewChatId():string{
        return "SELECT COALESCE(MAX(chatId),1) + 1 AS chatId FROM chats WHERE uid = :uid";
    }
    public function loadChats():string{
        return "SELECT * FROM chats WHERE uid = :uid ORDER BY chatId ASC ";
    }
    public function saveAIReply():string{
        return "UPDATE messages SET response = :AIReply WHERE msgId = :msgId";

    }
    public function saveLoginCredentials():string{
        return "INSERT INTO users(email_address,password_hash) VALUES(:email_address,:password_hash)";
    }
    public function storeChat():string{
        return "INSERT INTO chats(chatId,uid,title,createdAt) VALUES(:chatId,:uid,:title,:createdAt)";
    }
    public function chatExists():string{
        return "SELECT * FROM chats WHERE chatId = :chatId AND uid = :uid";
    }
    public function getLatestMessageId():string{
        return "SELECT MAX(msgId) AS msgId FROM messages WHERE uid = :uid";
    }
    public function loadMessages():string{
        return "SELECT * FROM messages WHERE chatId = :chatId AND uid = :uid ORDER BY msgId";
    }
    public function saveMessage(): string{
        return "INSERT INTO messages (chatId, uid, msg,createdAt) VALUES (:chatId,:uid, :msg, :createdAt)";
    }
    public function findByLoginCredentials(): string{
        return "SELECT * FROM users WHERE password_hash = :password_hash AND email_address = :email_address";
    }
    public function checkDuplicateEmail():string{
        return "SELECT * FROM users WHERE email_address = :email_address";
    }
    public function insertCode():string{
        return "INSERT INTO codes(email_address,verification_code,created_at,expires_at,verified) VALUES(:email_address,:verification_code,:created_at,:expires_at,:verified)";      
    }
}