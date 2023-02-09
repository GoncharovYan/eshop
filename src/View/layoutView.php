<?php
/**
 * @var string $style
 * @var string $content
 */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/resources/css/style.css">
	<title>Team&3-Eshop</title>
</head>
<body>
	<header>
		<div class="container">
			<a href="/catalog/all/1/"><img src="/resources/images/logo.png" width="190px" alt=""></a>
			<form class="search" method="GET">
				<label>
					<input type="search" placeholder="Поиск по сайту" class="input_text" name="search">
				</label>
				<button type="submit"><img src="/resources/images/icon-search.png" height="23px" width="22px" alt=""></button>
			</form>

			<?
			if(\Services\UserServices::checkAuth())
			{?>
				<div class=header-user>
					<p><?=\Services\UserServices::getLogin()?></p>
					<a id="logout-header-btn" href="/logout/">Выйти</a>
				</div>
			<?}
			else{?>
				<a href="/auth/"><img src="/resources/images/icon-user.png" width="35px" alt=""></a>
			<?}?>
		</div>
	</header>
	<hr>
	<main>
        <?= $content ?>
	</main>
	<hr>

	<footer>
	</footer>
</body>
</html>