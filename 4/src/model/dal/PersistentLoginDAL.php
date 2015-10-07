<?php

namespace model\dal;

class PersistentLoginDAL
{
    private $db;

    public function __construct(){
        $db = new Database();
        $this->db = $db->Establish();
    }

    public function Log(\model\PersistentLogin $credentials)
    {
        $stmt = $this->db->prepare("INSERT INTO persistent_login (username, passphrase, expiration) VALUES(?,?,?)");
        $stmt->execute(array($credentials->user, $credentials->passPhrase, date('Y-m-d H:i:s', $credentials->expiration)));
    }

    public function MatchRecord(\model\UserCredentials $credentials) : \bool
    {
        //Clean up the table by removing old passphrases
        $delete = $this->db->prepare("DELETE FROM persistent_login WHERE expiration < NOW()");
        $delete->execute();

        $stmt = $this->db->prepare("SELECT * FROM persistent_login WHERE username = ? AND passphrase = ? AND expiration > ?");
        $stmt->execute(array($credentials->GetUsername(), $credentials->GetPassword(), date('Y-m-d H:i:s')));

        return ($stmt->rowCount() == 1);

    }

}