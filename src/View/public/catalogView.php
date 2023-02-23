<?php
/**
 * @var array $productList
 * @var array $paginator
 * @var array $tagList
 * @var string $search
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
    <div class="products" id ="main-catalog-list">
        <? $catalogList = [];
        foreach ($productList as $product){
            $catalogList[] = [
                'id' => $product['id'],
                'title' => $product['item_name'],
                'shortDesc' => $product['short_desc'],
                'price' => $product['price'],
                'imagePath' => $product['imagePath'],
            ];
        }?>
	</div>
    <div class="paginator" id="main-paginator"></div>
    <script type="module">
        import {CatalogList} from '/resources/public/js/catalog-list.js';
        import {PageList} from '/resources/public/js/catalog-pagination.js';
        const  mainCatalogList = new CatalogList({
            attachToNodeId: 'main-catalog-list',
            items: <?= \Core\Web\Json::encode($catalogList)?>
        });
        mainCatalogList.render();
        const  mainPaginator = new PageList('main-paginator',
            <?=$paginator['curPage']?>,
            <?=$paginator['maxPage']?>,
            "<?=$search?>",
            mainCatalogList
        );
        mainPaginator.render();
    </script>
</div>