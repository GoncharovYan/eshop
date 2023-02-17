<?php
/**
 * @var array $items
 * @var array $counts
 * @var string $email
 * @var int $cost
 */
?>
<div class="order">
    <h1 class="order__title">Оформляем</h1>

    <div class="order-info">

        <div class="order-details">
            <p class="order-details__title">куда звонить</p>
            <form method="post" action="/checkout/">
                <input type="text" name="name" placeholder="Name">
                <input type="text" name="phone" placeholder="Phone">
                <input type="email" name="email" placeholder="E-mail" value="<?= $email ?>">
                <input type="text" name="address" placeholder="Address">
                <input type="text" name="comment" placeholder="Comment">

                <p class="order-details__total-price">
                    Всего денег: <span style="font-weight: bold">
                        <?= $cost ?></span>
                </p>
                <input class="order-details__confirm" type="submit" value="Да я покупаю всё">
            </form>
        </div>

        <div class="order-cart">
            <p class="order-cart__title">твоя корзинка</p>
            <div class="items">
                <?
                foreach ($items as $item):?>
                    <div class="item">
                        <p class="item__name"> <?= $item->item_name?><p>
                        <p class="item__count"> <?=$counts[$item->id]?><p>
                        <p class="item__price"> <?= $item->price * $counts[$item->id]?><p>
                    </div>
                <?endforeach; ?>
            </div>
        </div>

    </div>

</div>