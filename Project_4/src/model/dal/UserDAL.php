<?php


namespace model\dal;


class UserDAL
{
    private $db;
    private static $table = "user";

    private static $columnUsername = "username";
    private static $columnPassword = "password";

    public function __construct(\PDO $dal){
        $this->db = $dal;
    }

    public function GetAllUsers()
    {
        $ret = array();

        $stmt = $this->db->prepare("SELECT * FROM " . self::$table);
        $stmt->execute();

        while($user = $stmt->fetchObject()){
            $ret[] = new \model\UserCredentials($user->{self::$columnUsername}, $user->{self::$columnPassword});
        }
        return $ret;
    }

    public function Add(\model\UserCredentials $uc)
    {
        $stmt = $this->db->prepare("INSERT INTO " . self::$table . " (" . self::$columnUsername . ", " . self::$columnPassword . ") VALUES(?,?)");
        $stmt->execute(array($uc->GetUsername(), $uc->GetHashedPassword()));
    }

    public function UserExists(\model\UserCredentials $uc) : \bool
    {
        foreach($this->GetAllUsers() as $entry){
            /* @var $entry \model\UserCredentials */
            if($entry->GetUsername() == $uc->GetUsername()) {
                return true;
            }
        }
        return false;
    }
}