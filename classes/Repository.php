<?php
class Repository{
    protected DatabaseManager $DatabaseManager;
    protected QueryBuilder $QueryBuilder;
    
    public function __construct(){
        $this->DatabaseManager = new DatabaseManager();
        $this->QueryBuilder = new QueryBuilder();   
    }
}