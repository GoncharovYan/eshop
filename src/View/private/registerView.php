<div class="auth-form">
    <div class="auth-form-content">
        <p class="title-form">Регистрация</p>
        <form class="login-form" action="/register/" method="post">
            <label>E-mail</label>
            <input class="auth-input" name="email" type="text">
            <label>Логин</label>
            <input class="auth-input" name="login" type="text">
            <label>Пароль</label>
            <input class="auth-input" name="pass" type="password"/>
            <button type="submit" class="auth-form-btn" >Зарегистрироваться</button>
        </form>
        <a id="auth-page-btn" href="/auth/">Форма авторизации</a>
    </div>
</div>