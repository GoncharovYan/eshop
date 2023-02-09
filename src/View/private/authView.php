<div class="auth-form">
    <div class="auth-form-content">
        <p class="title-form">Авторизация</p>
        <form class="login-form" action="/auth/" method="post">
            <label>Логин</label>
            <input class="auth-input" name="login" type="text">
            <label>Пароль</label>
            <input class="auth-input" name="pass" type="password"/>
            <button type="submit" class="auth-form-btn" >Войти</button>
        </form>
        <a id="auth-page-btn" href="/register/">Зарегистрироваться</a>
    </div>
</div>