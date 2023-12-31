<?php

namespace Controller\private;

use Controller\BaseController;
use Models\User;
use Services\ConfigurationServices;
use Services\TokenServices;
use Services\UserServices;
use Validation\Validator;

class AuthController extends BaseController
{
	public function authPage()
	{
		session_start();
		if (isset($_SESSION['login']) && isset($_SESSION['pass']))
		{
			header("Location: /catalog/all/1/");
		}
		else
		{
            $token = TokenServices::createToken();

			echo $this->render('layoutView.php', [
				'content' => $this->render('private/authView.php', [
                    'token' => $token,
				]),
			]);
		}
	}

	public function registerPage()
	{
		session_start();
		if (isset($_SESSION['login']) && isset($_SESSION['pass']))
		{
			header("Location: /catalog/all/1/");
		}
		else
		{
		    $token = TokenServices::createToken();

			echo $this->render('layoutView.php', [
				'content' => $this->render('private/registerView.php', [
                    'token' => $token,
				]),
			]);
		}
	}

	public function authUser($data)
	{
        $minPassLength = ConfigurationServices::option('PASSWORD_MIN_LENGTH');

        session_start();

        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
        TokenServices::checkToken($token, $_SESSION['token'], "Bad token");


		$val = new Validator();
		$val->checkLogin($data['login']);
		$val->checkText($data['pass'], 'password', 62, $minPassLength);

		if (!$val->isSuccess())
		{
			$messages = $val->getErrors();
		}
		else
		{
			if (!UserServices::checkLogin($data['login']))
			{
				$messages [] = "Логин не найден!";
			}
			else
			{
				if (UserServices::checkPass($data['login'], $data['pass']))
				{
					$_SESSION['login'] = $data['login'];
					$_SESSION['pass'] = $data['pass'];
					$user = User::find([
						'conditions' => "LOGIN = '{$_SESSION['login']}'",
					]);
					$_SESSION['email'] = $user[0]->email;
					header("Location: /catalog/all/1/");
					exit;
				}
				else
				{
					$messages [] = "Неверный пароль!";
				}
			}
		}

		echo $this->render('layoutView.php', [
			'messages' => $messages,
			'content' => $this->render('private/authView.php', [
                'token' => $token,
			]),
		]);
	}

	public function registerUser($data)
	{
        $minPassLength = ConfigurationServices::option('PASSWORD_MIN_LENGTH');

	    session_start();

        $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
        TokenServices::checkToken($token, $_SESSION['token'], "Bad token");

		$val = new Validator();
		$val->checkEmail($data['email']);
		$val->checkLogin($data['login']);
		$val->checkText($data['pass'], 'password', 62, $minPassLength);

		if (!$val->isSuccess())
		{
			$messages = $val->getErrors();
			echo $this->render('layoutView.php', [
				'messages' => $messages,
				'content' => $this->render('private/registerView.php', [
                    'token' => $token,
				]),
			]);
			exit;
		}

		if (!UserServices::checkLogin($data['login']))
		{
			$pass = password_hash($data['pass'], PASSWORD_DEFAULT);
			$newUser = new User();
			$newUser->login = $data['login'];
			$newUser->password = $pass;
			$newUser->email = $data['email'];
			$newUser->role = 1;
			$newUser->save();

			$messages[] = "Регистрация прошла успешно!";
			echo $this->render('layoutView.php', [
				'messages' => $messages,
				'content' => $this->render('private/authView.php', [
                    'token' => $token,
				]),
			]);
		}
		else
		{
			$messages[] = "Сожалеем, но данный логин занят!";
			echo $this->render('layoutView.php', [
				'messages' => $messages,
				'content' => $this->render('private/registerView.php', [
                    'token' => $token,
				]),
			]);
		}
	}

	public function logOutUser()
	{
		session_start();
		$_SESSION['login'] = null;
		$_SESSION['pass'] = null;
		header("Location: /catalog/all/1/");
	}

}