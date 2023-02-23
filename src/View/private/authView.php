<div class="auth-form">
    <div class="auth-form-content">
        <p class="title-form">Авторизация</p>
        <form class="login-form" action="/auth/" method="post" onsubmit="return validateAuthForm()">
            <label>Логин</label>
            <input class="auth-input" name="login" type="text" id="auth-login">
            <label>Пароль</label>
            <input class="auth-input" name="pass" type="password" id="auth-pass">
            <button type="submit"  class="auth-form-btn" >Войти</button>
        </form>
        <a id="auth-page-btn" href="/registr/">Зарегистрироваться</a>
    </div>
    <script src="/resources/public/js/user-forms.js"></script>
</div>