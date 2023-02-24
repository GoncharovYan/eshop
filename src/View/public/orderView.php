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

            <form method="post" action="/checkout/" onsubmit="return checkInputForm()">
                <input class="form-field" type="text" name="name" placeholder="*Name">
                <input class="form-field" type="text" name="phone" placeholder="*Phone">
                <input class="form-field" type="email" name="email" placeholder="*E-mail" value="<?= $email ?>">
                <input class="form-field" type="text" name="address" placeholder="*Address">
                <input class="form-field" type="text" name="comment" placeholder="Comment">

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
                    <div class="item">
                        <p class="item__name"> <?= $item->item_name?><p>
                        <p class="item__count"> <?=$counts[$item->id]?><p>
                        <p class="item__price"> <?= $item->price * $counts[$item->id]?><p>
                    </div>
				<?php
				endforeach; ?>
            </div>
        </div>

    </div>

</div>
<script src="/resources/public/js/formInputCheck.js"></script>