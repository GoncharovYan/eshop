<?php


namespace Services;


use Models\User;

class UserServices
{
    public static function checkLogin(string $login): bool
    {
        $user = User::find([
            'conditions'=> "LOGIN = '$login'"
        ]);
        if(isset($user[0]))
        {
            return false;
        }
        return true;
    }

    public static function checkPass(string $login, string $pass): bool
    {
        $user = User::find([
            'conditions'=> "LOGIN = '$login'"
        ]);
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
        $adminRole = '0';
        if(isset($_SESSION['login'])&&isset($_SESSION['pass']))
        {
            if(UserServices::checkPass($_SESSION['login'],$_SESSION['pass']))
            {
                $user = User::find([
                    'conditions'=> "LOGIN = '{$_SESSION['login']}'"
                ]);
                if($user[0]->role === $adminRole)
                {
                    return true;
                }
            }
        }
        return false;
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

