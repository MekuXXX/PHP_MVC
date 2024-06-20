<?php

namespace App\Core;

class Session
{
    protected const FLASH_KEY = "flash_messages";
    public function __construct() 
    {
        session_start();
        $flashMessages = &$_SESSION[self::FLASH_KEY] ?? [];
        
        // echo "<pre>";
        // var_dump($flashMessages);
        // echo "</pre>";

        foreach ($flashMessages as $key => &$message)
        {
            $message["remove"] = true;             
        }
    }

    public function setFlash(string $key, string $message) 
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];         
    }

    public function getFlash(string $key): string | bool
    {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }
    
    public function __destruct() 
    {
        $flashMessages = &$_SESSION[self::FLASH_KEY] ?? [];
        
        foreach ($flashMessages as $key => &$message)
        {
            if ($message["remove"]) 
            {
                unset($flashMessages[$key]);
            }
        }
    }
}   