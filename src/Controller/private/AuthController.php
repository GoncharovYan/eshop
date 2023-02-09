<?php

namespace Controller\private;
use Controller\BaseController;
use Models\User;
use Services\UserServices;

class AuthController extends BaseController
{
    public function authPage()
    {
        session_start();
        if(isset($_SESSION['login'])&&isset($_SESSION['pass']))
        {
            header("Location: /catalog/all/1/");
        }
        else
        {
            echo $this->render('layoutView.php', [
                'content' => $this->render('private/authView.php', [
                ]),
            ]);
        }
    }

    public function registerPage()
    {
        session_start();
        if(isset($_SESSION['login'])&&isset($_SESSION['pass']))
        {
            header("Location: /catalog/all/1/");
        }
        else {
            echo $this->render('layoutView.php', [
                'content' => $this->render('private/registerView.php', [
                ]),
            ]);
        }
    }

    public function authUser($data)
    {
       session_start();
       if(UserServices::checkPass($data['login'],$data['pass']))
       {
           $_SESSION['login'] = $data['login'];
           $_SESSION['pass'] = $data['pass'];
           $user = User::executeQuery("SELECT * 
                    FROM user 
                    WHERE LOGIN = '{$data['login']}'");
           $_SESSION['email'] = $user[0]->email;



       }
       header("Location: /catalog/all/1/");
    }

    public function registerUser($data)
    {
        if(isset($data['email'], $data['login'], $data['pass']))
        {
            if(UserServices::checkLogin($data['login']))
            {
                $pass = password_hash($data['pass'], PASSWORD_DEFAULT);
                User::executeQuery("
                    INSERT INTO user (EMAIL, LOGIN, PASSWORD, ROLE)
                    VALUES ('{$data['email']}','{$data['login']}','{$pass}',1);"
                );
                header("Location: /auth/");
            }
        }
        header("Location: /register/");
    }

    public function logOutUser()
    {
        session_start();
        $_SESSION['login'] = null;
        $_SESSION['pass'] = null;
        header("Location: /catalog/all/1/");
    }

}