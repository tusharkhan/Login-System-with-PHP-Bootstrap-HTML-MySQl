<?php
/**
 * Created by PhpStorm.
 * User: Tanzil
 * Date: 4/25/2017
 * Time: 4:34 PM
 */
    class Session
    {

        public static function init()
        {
            if(version_compare(phpversion(), '5.4.0', '<') )
            {
                if(empty(session_id()))
                {
                    session_start();
                }//checking Session Id
            }//Checking PHP Version
            else
            {
                if(session_status() == PHP_SESSION_NONE)
                {
                    session_start();
                }//Checking PHP_SESSION_NUN
            }
        }//Public Init Function

        public static function set($key, $value)
        {
            $_SESSION[$key] = $value;
        }//Public Set Function

        public static function get($key)
        {
            if(isset($_SESSION[$key]))
            {
                return $_SESSION[$key];
            }//Checking if $key is Set
            else
            {
                return false;
            }
        }//Public Get Function

        public static function sessionDestroy()
        {
            session_destroy();
            session_unset();
            header("Location: login.php");
        }//Session Destroy Function


        public static function checkSession()
        {
            if(self::get("login") == false)
            {
                self::sessionDestroy();
                header("Location: login.php");
            }
        }//Check Session

        public static function checkLogin()
        {
            if(self::get("login") == true)
            {
                header("Location: index.php");
            }
        }//Check Login
    }//Main Session Class
?>