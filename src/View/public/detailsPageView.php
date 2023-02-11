<?php
/**
 * @var \Models\Item $product
 * @var array $tags
 */
?>


<div class="details">
		<div><img src="" width="690px" height="570px"></div>
		<div class="profile">
			<h2><?= $product->item_name ?></h2>
			<p class="long-description"><?= $product->full_desc ?></p>
			<hr>
			<div class="tags">
                <? foreach ($tags as $tag): ?>
				    <a>#<?= $tag->tag_name ?></a>
                <? endforeach; ?>
			</div>
			<div class="wrapper">
			<p><?= $product->price ?> руб</p>
			<a href="/product/order/<?= $product->id ?>/" class="button">Оформить</a>
			</div>
		</div>
	</div>