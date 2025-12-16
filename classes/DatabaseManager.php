<?php
class DatabaseManager{
    private object $pdo;
    public function __construct(){
        $dbConnection = Config::dbConnection();
        if($_SERVER['HTTP_HOST'] == "localhost"){
            $dsn = $dbConnection['dsn'];
            $user = $dbConnection['user'];
            $pass = $dbConnection['pass'];    
        }
        else{
            $dsn = $dbConnection['dsn'];
            $user = $dbConnection['user'];
            $pass = $dbConnection['pass'];  
        }
        $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } 
    public function fetchAll(string $sql,array $params = []):array{
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function fetchOne(string $sql,array $params = []):?array{
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return $row ?: null;
    }
    public function fetch(string $sql){
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function execute(string $sql, array $params = []): bool {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}