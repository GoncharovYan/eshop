<?php
/**
 * @var array $items
 * @var array $counts
 */
?>

<div class="order">
    <? foreach ($items as $item):?>
    <dib class="item">
        <p>Name: <?= $item->item_name?><p>
        <p>Count: <?=$counts[$item->id]?><p>
    </dib>
    <? endforeach;?>

    <button>Да я покупаю всё</button>
</div>