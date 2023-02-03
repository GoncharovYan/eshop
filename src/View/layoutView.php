<?php

/**
 * @var string $content

 */
?>


<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/resources/css/style-main.css">
	<link rel="stylesheet" href="/resources/css/style-details.css">
	<title>Team&3-Eshop</title>
</head>
<body>
	<header>
		<div class="container">
			<a href=""><img src="/resources/images/logo.png" width="190px" alt=""></a>
			<div class="search">
				<label>
					<input type="search" value="Поиск по сайту" class="input_text">
				</label>
				<button><img src="/resources/images/icon-search.png" height="23px" width="22px" alt=""></button>
			</div>
			<a><img src="/resources/images/icon-user.png" width="35px"></a>
		</div>
<!--		подумать над шириной-->

<!--		<nav class="header-links">Главная</nav>-->
	</header>

	<main>
        <?= $content ?>
	</main>
	<hr>

	<footer>
	</footer>
</body>
</html>