<?php


namespace Services;


use Models\User;

class UserServices
{
    public static function checkLogin(string $login): bool
    {
        $user = User::executeQuery("SELECT * 
                    FROM user 
                    WHERE LOGIN = '{$login}'");
        if(isset($user[0]))
        {
            return false;
        }
        return true;
    }

    public static function checkPass(string $login, string $pass): bool
    {
        $user = User::executeQuery("SELECT * 
                    FROM user 
                    WHERE LOGIN = '{$login}'");

        if($user !== null)
        {
            if(password_verify($pass, $user[0]->password))
            {
                return true;
            }

        }
        return false;
    }

    public static function checkAuth(): bool
    {
        session_start();
        if(isset($_SESSION['login']))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function isAdmin(): bool
    {
        session_start();
        $check = false;
        $adminRole = '1';
        if(isset($_SESSION['login'])&&isset($_SESSION['pass']))
        {
            $user = User::executeQuery("SELECT * 
                    FROM user 
                    WHERE LOGIN = '{$_SESSION['login']}'");
            if($user[0]->password === $_SESSION['pass'])
            {
                if($user[0]->role === $adminRole)
                {
                    return true;
                }
            }
        }
        return $check;
    }

    public static function getLogin(): ?string
    {
        session_start();
        if(isset($_SESSION['login']))
        {
            return $_SESSION['login'];
        }
        else
        {
            return null;
        }
    }
}

