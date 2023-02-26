<div class="auth-form">
    <div class="auth-form-content">
        <p class="title-form">Регистрация</p>
        <form class="login-form" action="/registration/" method="post" onsubmit="return validateRegistrForm()">
            <label>E-mail</label>
            <input required class="auth-input" name="email" type="email" id="reg-email">
            <label>Логин</label>
            <input required class="auth-input" name="login" type="text" id="reg-login" maxlength="62">
            <label>Пароль</label>
            <input required class="auth-input" name="pass" type="password" id="reg-pass" minlength="5" maxlength="62"/>
            <button type="submit" class="auth-form-btn" >Зарегистрироваться</button>
        </form>
        <a id="auth-page-btn" href="/auth/">Форма авторизации</a>
    </div>
</div>