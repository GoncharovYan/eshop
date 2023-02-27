<?php
/**
 * @var string $token
 */
?>

<div class="auth-form">
    <div class="auth-form-content">
        <p class="title-form">Авторизация</p>
        <form class="login-form" action="/auth/" method="post" onsubmit="return validateAuthForm()">
            <label>Логин</label>
            <input required class="auth-input" name="login" type="text" id="auth-login"  maxlength="62">
            <label>Пароль</label>
            <input required class="auth-input" name="pass" type="password" id="auth-pass" minlength="5" maxlength="62">
            <button type="submit"  class="auth-form-btn" >Войти</button>
            <input type="hidden" name="token" value="<?= $token?>">
        </form>
        <a id="auth-page-btn" href="/registration/">Зарегистрироваться</a>
    </div>
</div>