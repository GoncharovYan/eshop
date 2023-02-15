
<?php
/**
 * @var string $cost
 * @var string $email
 */
?>
<div class="auth-form">
    <div class="auth-form-content">
        <p class="title-form">Оформление заказа</p>

        <form class="login-form" action="/auth/" method="post">
            <label>ФИО</label>
            <input class="auth-input" name="login" type="text">
            <label>Номер телефона</label>
            <input class="auth-input" name="pass" type="text"/>
            <label>E-mail</label>
            <input class="auth-input" name="pass" type="text" value="<?=$email?>"/>
            <label>Адрес</label>
            <input class="auth-input" name="pass" type="text"/>
            <p class="title-form">Итоговая цена: <?=$cost?></p>
            <button type="submit" class="auth-form-btn" >Заказать</button>
        </form>
    </div>
</div>