<?php

/**
 * @var string $content
 */
?>


<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="/resources/admin/css/admin.css">
	<title>Team&3-Eshop</title>
</head>
<body>
<header class="p-3 bg-dark text-white">
	<div class="container">
		<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
			<a href="/" class="d-flex mb-2 mb-lg-0 text-white text-decoration-none">
				<svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="/resources/images/logo.png"></use></svg>
			</a>

			<ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
				<li><a href="/catalog/all/1/" class="nav-link px-2 text-white">На главную</a></li>
				<li><a href="/admin/user/" class="nav-link px-2 text-white">Пользователи</a></li>
				<li><a href="/admin/item/" class="nav-link px-2 text-white">Товары</a></li>
				<li><a href="/admin/tag/" class="nav-link px-2 text-white">Теги</a></li>
				<li><a href="/admin/orders/" class="nav-link px-2 text-white">Заказы</a></li>
				<li><a href="/admin/image/" class="nav-link px-2 text-white">Картинки</a></li>
			</ul>

			<form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
				<input type="search" class="form-control form-control-dark" id="elastic" placeholder="Поиск">
			</form>

		</div>
	</div>
</header>
	<main>
		<?= $content ?>
	</main>
</body>
</html>