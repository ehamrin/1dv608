<?php

namespace model\dal;

class PersistentLoginDAL
{
    private static $table = "persistent_login";
    private static $columnUsername = "username";
    private static $columnPassphrase = "passphrase";
    private static $columnExpiration = "expiration";

    private $db;

    public function __construct(\PDO $dal){
        $this->db = $dal;
    }

    public function Log(\model\PersistentLogin $credentials)
    {
        $stmt = $this->db->prepare("INSERT INTO " . self::$table . " (" . self::$columnUsername . ", " . self::$columnPassphrase . ", " . self::$columnExpiration . ") VALUES(?,?,?)");
        $stmt->execute(array($credentials->user, $credentials->passPhrase, date('Y-m-d H:i:s', $credentials->expiration)));
    }

    public function MatchRecord(\model\UserCredentials $credentials) : \bool
    {
        //Clean up the table by removing old passphrases
        $delete = $this->db->prepare("DELETE FROM " . self::$table . " WHERE " . self::$columnExpiration . " < NOW()");
        $delete->execute();

        $stmt = $this->db->prepare("SELECT * FROM " . self::$table . " WHERE " . self::$columnUsername . " = ? AND " . self::$columnPassphrase . " = ? AND " . self::$columnExpiration . " > ?");
        $stmt->execute(array($credentials->GetUsername(), $credentials->GetPassword(), date('Y-m-d H:i:s')));

        return ($stmt->rowCount() == 1);

    }

}