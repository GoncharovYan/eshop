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
	<link rel="stylesheet" href="/resources/css/style-main.css">
    <link rel="stylesheet" href="/resources/css/style-details.css">
    <link rel="stylesheet" href="/resources/css/style-auth.css">
	<title>Team&3-Eshop</title>
</head>
<body>
	<header>
		<div class="container">
			<a href="/catalog/all/1/"><img src="/resources/images/logo.png" width="190px" alt=""></a>
			<div class="search">
				<label>
					<input type="search" value="Поиск по сайту" class="input_text">
				</label>
				<button><img src="/resources/images/icon-search.png" height="23px" width="22px" alt=""></button>
			</div>
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