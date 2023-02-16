<?php
/**
 * @var \Models\Item $product
 * @var array $tags
 * @var array $imagePath
 */
?>


<div class="details">
		<div class="images">
			<?for ($i = 0; $i < count($imagePath); $i++){?>
			<img class="main-image img" src="<?= $imagePath[$i]?>" width="690px" height="600px" style="display: none">
			<?}?>

			<?for ($i = 0; $i< count($imagePath); $i++){?>
			<img class="mini-image<?=$i+1?> mini-img" src="<?=$imagePath[$i]?>" width="130px" height="120px" style="object-fit: cover;">
			<?}?>
		</div>

		<div class="profile">
			<h2><?= $product->item_name ?></h2>
			<p class="long-description"><?= $product->full_desc ?></p>
			<hr>
			<div class="tags">
                <? foreach ($tags as $tag): ?>
				    <a href="/catalog/<?=$tag["alias"]?>/1/">#<?= $tag["tag_name"] ?></a>
                <? endforeach; ?>
			</div>
			<div class="wrapper">
			<p><?= $product->price . " ₽"?></p>
			<a href="/product/order/<?= $product->id ?>/" class="button">В корзину</a>
			</div>
		</div>
	<a class="previous" onclick="previousSlide()" style="margin-left: -50px">&#10094;</a>
	<a class="next" onclick="nextSlide()" style="margin-left: 700px">&#10095;</a>

	<script src="/resources/public/js/slider.js">
	</script>
	</div>