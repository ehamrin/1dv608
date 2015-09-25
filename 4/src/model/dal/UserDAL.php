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
}