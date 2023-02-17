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
	<link rel="stylesheet" href="/resources/public/css/style.css">
	<title>Team&3-Eshop</title>
</head>
<body>
	<header>
		<div class="container">
			<a href="/catalog/all/1/">
                <img src="/resources/public/images/logo.png" class="logo" alt="logo">
            </a>
			<form action="/catalog/all/1/" class="search" method="GET" >
                <input type="search" placeholder="Поиск по сайту" name="search" id="search-text">

				<button type="button" onclick="searchItem()">
                    <img src="/resources/public/images/icon-search.png" class="search__icon" alt="search">
                </button>
			</form>

            <div class="links">
                <a href="/order/" class="order-button button">
                    <img src="/resources/public/images/icon-cart.png"alt="">
                </a>
                <? if(\Services\UserServices::isAdmin())
                {?>
                    <a href="/admin/item/" class="admin-button button">
                        <img src="/resources/public/images/icon-admin.png"alt="">
                    </a>
                <?}?>
                <? if(\Services\UserServices::checkAuth())
                {?>
                    <div class=header-user>
                        <p><?=\Services\UserServices::getLogin()?></p>
                        <a id="logout-header-btn" href="/logout/">Выйти</a>
                    </div>
                <?}
                else{?>
                    <a href="/auth/" class="auth-button button">
                        <img src="/resources/public/images/icon-user.png" alt="">
                    </a>
                <?}?>
            </div>
		</div>
	</header>
	<hr>
	<main>
        <?= $content ?>
	</main>
    <script src="/resources/public/js/catalog-search.js"></script>
	<footer>
	</footer>
</body>
</html>