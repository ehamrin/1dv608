<?php


namespace model\dal;


class Login
{
    private static $logfile = LOG_FILE_DIR . "persistent_authentication.log";

    private static $username = 0;
    private static $securityString = 1;
    private static $expiration = 2;
    private static $dataDelimiter = ';';

    public function recordPersistentAuthentication(\model\PersistentLogin $credentials){

        $file_handle = fopen(self::$logfile, 'a');
        $stringData = implode(self::$dataDelimiter, [self::$username => $credentials->user, self::$securityString => $credentials->securityString, self::$expiration => $credentials->expiration]);
        fwrite($file_handle, $stringData . PHP_EOL);
        fclose($file_handle);
    }

    public function matchPersistentAuthentication($user, $securityStringCookie){
        $file_handle = fopen(self::$logfile, "r");
        while (!feof($file_handle)) {
            $line = fgets($file_handle);
            $data = explode(self::$dataDelimiter, $line);

            if($data[self::$username] == $user && $data[self::$securityString] == $securityStringCookie && $data[self::$expiration] > time()){
                fclose($file_handle);
                return true;
            }
        }
        fclose($file_handle);

        return false;
    }

}