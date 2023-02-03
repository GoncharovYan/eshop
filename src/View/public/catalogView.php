<?php
/**
 * @var array $productList
 * @var array $paginator
 * @var array $tagList
 */
?>


<div class="tags">
		<ul>
			<? for($i = 0, $iMax = count($tagList); $i < $iMax; $i++) {?>
				<a href="#"><li>#<?= $tagList[$i]->name?></li></a>
			<?}?>
		</ul>
</div>
<div class="catalog">
    <div class="products">
        <?for($i = 0; $i < count($productList); $i++){?>
            <div class="item">
            <img src="" height="165px" width="195px">
            <p class="name"><?= $productList[$i]->name?></p>
            <span>описание</span>
            <p class="price"><?= $productList[$i]->price?></p>
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
