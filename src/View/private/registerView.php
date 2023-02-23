<div class="auth-form">
    <div class="auth-form-content">
        <p class="title-form">Регистрация</p>
        <form class="login-form" action="/registr/" method="post" onsubmit="return validateRegistrForm()">
            <label>E-mail</label>
            <input class="auth-input" name="email" type="email" id="reg-email">
            <label>Логин</label>
            <input class="auth-input" name="login" type="text" id="reg-login">
            <label>Пароль</label>
            <input class="auth-input" name="pass" type="password" id="reg-pass"/>
            <button type="submit" class="auth-form-btn" >Зарегистрироваться</button>
        </form>
        <a id="auth-page-btn" href="/auth/">Форма авторизации</a>
    </div>
    <script src="/resources/public/js/user-forms.js"></script>
</div>