<?php


namespace model\dal;


class UserDAL
{
    private $db;

    public function __construct(){
        $db = new Database();
        $this->db = $db->Establish();
    }

    public function GetAllUsers()
    {
        $ret = array();

        $stmt = $this->db->prepare("SELECT * FROM user");
        $stmt->execute();

        while($user = $stmt->fetchObject()){
            $ret[] = new \model\UserCredentials($user->username, $user->password);
        }
        return $ret;
    }

    public function Add(\model\UserCredentials $uc)
    {
        $stmt = $this->db->prepare("INSERT INTO user (username, password) VALUES(?,?)");
        $stmt->execute(array($uc->GetUsername(), $uc->GetHashedPassword()));
    }

    public function UserExists(\model\UserCredentials $uc){
        foreach($this->GetAllUsers() as $entry){
            /* @var $entry \model\UserCredentials */
            if($entry->GetUsername() == $uc->GetUsername()) {
                return true;
            }
        }
        return false;
    }
}