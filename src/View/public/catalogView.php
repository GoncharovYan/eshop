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

    <div class="products" id ="catalog-list">
		<? foreach ($productList as $product){?>
			<div class="item">
				<img src="<?= $imagePathList[$product->id] ?>" alt="">
				<p class="name"><a href="/product/<?=$product->id?>/"><?= $product->item_name?></a></p>
				<span><?= $product->short_desc?></span>
				<p class="price"><?= $product->price . " ₽"?></p>
			</div>
		<?}?>
        <? $catalogList = [];
        foreach ($productList as $product){
            $catalogList[] = [
                'id' => $product->id,
                'title' => $product->item_name,
                'description' => $product->short_desc,
                'price' => $product->price,
                'imagePath' => $imagePathList[$product->id],
            ];
        }?>
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
    <script type="module">
        import {CatalogList} from '/resources/public/js/catalog-list.js';
        const  mainCatalogList = new CatalogList({
            attachToNodeId: 'catalog-list',
            items: <?= \Core\Web\Json::encode($catalogList)?>
        });
    </script>
</div>