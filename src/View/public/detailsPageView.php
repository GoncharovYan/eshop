<?php
/**
 * @var \Models\Item $product
 */
?>


<div class="details">
		<div><img src="" width="690px" height="570px"></div>
		<div class="profile">
			<h2><?= $product->item_name ?></h2>
			<p class="long-description"><?= $product->full_desc ?></p>
			<hr>
			<div class="tags-wrapper">
				<a>#Электроника</a>
				<a>#Ноутбук</a>
				<a>#Белый</a>
				<a>#Что-то еще</a>
			</div>
			<div class="wrapper">
			<p><?= $product->price ?> руб</p>
			<a href="/product/order/<?= $product->id ?>/">Оформить</a>
			</div>
		</div>
	</div>