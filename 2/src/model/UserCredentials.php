<?php


namespace model;


class UserCredentials
{
    private $username;
    private $password;

    public function __construct(\string $username, \string $password){
        if(empty($username)){
            throw new \InvalidArgumentException("Username must be set");
        }
        if(empty($password)){
            throw new \InvalidArgumentException("Username must be set");
        }
        $this->username = $username;
        $this->password = $password;
    }

    public function GetUsername() : \string
    {
        return $this->username;
    }

    public function GetPassword() : \string
    {
        return $this->password;
    }
}