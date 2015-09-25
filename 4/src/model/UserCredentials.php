<?php
declare(strict_types=STRICT_TYPING);

namespace model;


class UserCredentials
{
    private $username;
    private $password;
    private $uniqueClientIdentifier;

    public function __construct(\string $username, \string $password, \string $unique = null){
        if(empty($username)){
            throw new \UsernameMissingException("Username must be set");
        }

        if(strlen($username) < 3){
            throw new \UsernameTooShortException("Username is too short");
        }

        if(empty($password)){
            throw new \PasswordMissingException("Password must be set");
        }

        if(strlen($password) < 6){
            throw new \PasswordTooShortException("Password is too short");
        }

        $this->username = $username;
        $this->password = $password;
        $this->uniqueClientIdentifier = $unique;
    }

    public function GetUsername() : \string
    {
        return $this->username;
    }

    public function GetPassword() : \string
    {
        return $this->password;
    }

    public function GetUniqueClientIdentifier() : \string
    {
        return $this->uniqueClientIdentifier;
    }
}