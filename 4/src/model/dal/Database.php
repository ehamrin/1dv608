<?php


namespace model\dal;


class Database
{
    private static $Dsn = 'localhost';
    private static $Database = '1dv608registration';
    private static $User = 'AppUser';
    private static $Password = 'PL6DvzxEqyxqFERK';

    public function Establish()
    {
        try{
            return new \PDO('mysql:host=' . self::$Dsn . ';dbname=' . self::$Database . ';', self::$User, self::$Password, array(\PDO::FETCH_OBJ));
        }catch (\PDOException $e){
            throw new \DatabaseConnectionException("Unable to connect to database");
        }

    }
}
