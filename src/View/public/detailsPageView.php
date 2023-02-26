<?php
/**
 * @var array $product
 * @var array $tags
 * @var array $imagePath
 * @var int $count
 */
?>


<div class="details">
		<div class="images">
			<?php
			for ($i = 0; $i < count($imagePath); $i++){?>
			<img class="main-image img" src="<?= $imagePath[$i]->path?>" width="690px" height="600px" style="display: none">
			<?php
			}?>

			<?php
			for ($i = 0; $i< count($imagePath); $i++){?>
			<img class="mini-image<?=$i+1?> mini-img" src="<?=$imagePath[$i]->path?>" width="130px" height="120px" style="object-fit: cover;">
			<?php
			}?>
		</div>

		<div class="profile">
			<h2><?= $product->item_name ?></h2>
			<p class="long-description"><?=$product->full_desc?></p>
			<hr>
			<div class="tags">
				<?php
				foreach ($tags as $tag): ?>
				    <a href="/catalog/<?=$tag["alias"]?>/1/">#<?= $tag["tag_name"] ?></a>
				<?php
				endforeach; ?>
			</div>
			<div class="wrapper">
                <div
                     class="hidden"
                     id="data"
                     data-count="<?= $count ?>"
                     data-id="<?= $product->id ?>">
                </div>
                <p><?= $product->price . " ₽"?></p>
            </div>
		</div>
	<a class="previous" onclick="previousSlide()" style="margin-left: -50px">&#10094;</a>
	<a class="next" onclick="nextSlide()" style="margin-left: 700px">&#10095;</a>

	<script src="/resources/public/js/slider.js"></script>
    <script src="/resources/public/js/details-cart.js"></script>
	</div>