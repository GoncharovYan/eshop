<?php

namespace Services;

use Controller\public\OrderController;

class TokenServices
{
	public static function createToken()
	{
		session_start();

		if ($_SERVER['REQUEST_METHOD'] === 'GET')
		{
			$_SESSION['token'] = bin2hex(random_bytes(35));
			return $_SESSION['token'];
		}
	}

	public static function checkToken(?string $token, ?string $sessionToken, string $error): void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			if (!$token || $token !== $sessionToken)
			{
				$controller = new OrderController();
				echo $controller->render('layoutView.php', [
					'content' => $controller->render('public/pageNotFoundView.php', [
						'error' => $error,
					]),
				]);

				header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
				exit;
			}
		}
	}
}