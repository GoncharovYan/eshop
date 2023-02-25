<?php
/**
 * @var array $items
 * @var array $counts
 * @var string $email
 * @var int $cost
 * @var string $token
 * @var int $errors
 */
?>
<div class="order">
    <h1 class="order__title">Оформляем</h1>

    <div class="order-info">

        <div class="order-details" id="order-div">
            <p class="order-details__title" id="first-p-child">куда звонить</p>

            <form method="post" action="/order/">
                <input required сlass="form-field" type="text"  name="name" placeholder="*Name" maxlength="254">
                <input required class="form-field" type="tel" name="phone"  placeholder="*Phone" pattern="[+][7][0-9]{10}">
                <input required class="form-field" type="email" name="email" placeholder="*E-mail" maxlength="126" value="<?= $email ?>">
                <input required class="form-field" type="text" name="address" placeholder="*Address" maxlength="254">
                <input class="form-field" type="text" name="comment" placeholder="Comment" maxlength="1022">

                <p class="order-details__total-price">
                    Всего денег: <span style="font-weight: bold">
                        <?= $cost ?></span>
                </p>
                <input class="order-details__confirm" type="submit" value="Да я покупаю всё">
				<input type="hidden" name="token" value="<?= $token?>">
            </form>
        </div>

        <div class="order-cart">
            <p class="order-cart__title">твоя корзинка</p>
            <div class="items">
				<?php
                foreach ($items as $item):?>
                    <div class="item" id="item-id-<?= $item->id ?>">
                        <p class="item__name"> <?= $item->item_name?><p>
                        <div class="item__count">
                            <div class="counter" onclick="modifyCart(<?= $item->id ?>, -1)">-</div>
                            <p  id="item-id-<?= $item->id ?>-count"><?=$counts[$item->id]?></p>
                            <div class="counter" onclick="modifyCart(<?= $item->id ?>, 1)">+</div>
                        </div>
                        <p class="item__price"> <?= $item->price * $counts[$item->id]?><p>
                        <p class="item__del" onclick="deleteFromCart(<?= $item->id ?>)"><span>×</span></p>
                    </div>
				<?php
				endforeach; ?>
            </div>
        </div>

    </div>

    <script src="/resources/public/js/cart.js"></script>
    <script src="/resources/public/js/formInputCheck.js"></script>
</div>