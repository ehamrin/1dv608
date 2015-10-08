<?php


namespace model\dal;


class Database
{
    private $dsn;
    private $database;
    private $username;
    private $password;

    public function __construct(\string $dsn, \string $database, \string $username, \string $password){
        $this->dsn = $dsn;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function Establish()
    {
        try{
            return new \PDO('mysql:host=' . $this->dsn . ';dbname=' . $this->database . ';', $this->username, $this->password, array(\PDO::FETCH_OBJ));
        }catch (\PDOException $e){
            throw new \DatabaseConnectionException("Unable to connect to database");
        }

    }
}
