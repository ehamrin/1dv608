<?php


namespace model\dal;


class Database
{

    public function Establish()
    {
        try{
            return new \PDO('mysql:host=' . \Settings::DB_DSN . ';dbname=' . \Settings::DB_Database . ';', \Settings::DB_User, \Settings::DB_Password, array(\PDO::FETCH_OBJ));
        }catch (\PDOException $e){
            throw new \DatabaseConnectionException("Unable to connect to database");
        }

    }
}
