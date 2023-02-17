<?php
/**
 * @var array $productList
 * @var array $paginator
 * @var array $tagList
 * @var array $imagePathList
 */
?>

<div class="catalog">
    <div class="tags">
            <ul>
                <? foreach ($tagList as $tag) {?>
                    <a href="/catalog/<?=$tag->alias?>/1/"><li>#<?= $tag->tag_name?></li></a>
                <?}?>
            </ul>
    </div>

    <div class="products">
		<? foreach ($productList as $product){?>
			<div class="item">
				<img src="<?= $imagePathList[$product->id-1] ?>" alt="">
				<p class="name"><a href="/product/<?=$product->id?>/"><?= $product->item_name?></a></p>
				<span><?= $product->short_desc?></span>
				<p class="price"><?= $product->price . " ₽"?></p>
			</div>
		<?}?>
	</div>
    <div class="paginator">
        <?foreach ($paginator as $page){
            if($page['ref'] !== null){?>
                <a href ="../<?=$page['ref'] ?>/" class="page"><?=$page['text']?></a>
            <?}else{?>
                <div class="no-page"><?=$page['text']?></div>
            <?}
        }?>
    </div>
</div>