<?php


namespace model\dal;


class PersistentLoginDAL
{
    private static $logfile = LOG_FILE_DIR . "persistent_authentication.Log";

    private static $username = 0;
    private static $passPhrase = 1;
    private static $expiration = 2;
    private static $dataDelimiter = ';';

    public function Log(\model\PersistentLoginModel $credentials)
    {

        $file_handle = fopen(self::$logfile, 'a');
        $dataArray = [self::$username => $credentials->user, self::$passPhrase => $credentials->passPhrase, self::$expiration => $credentials->expiration];
        $stringData = implode(self::$dataDelimiter, $dataArray);
        fwrite($file_handle, $stringData . PHP_EOL);
        fclose($file_handle);
    }

    public function MatchRecord(\string $user, \string $passPhrase) : bool{
        $file_handle = fopen(self::$logfile, "r");
        while (!feof($file_handle)) {

            $data = explode(self::$dataDelimiter, fgets($file_handle));

            if($data[self::$username] == $user && $data[self::$passPhrase] == $passPhrase && $data[self::$expiration] > time()){
                fclose($file_handle);
                return true;
            }
        }
        fclose($file_handle);

        return false;
    }

}