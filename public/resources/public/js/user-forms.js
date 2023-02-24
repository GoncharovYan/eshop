function validateAuthForm()
{
    let user = document.getElementById("auth-login").value
    if((user.length) === 0 || !user.match(/^[a-zA-Z0-9]+$/))
    {
        window.alert(`Логин должен содержать только буквы латинского алфавита и цифры`)
        return false
    }
    if((user.length) > 62)
    {
        window.alert(`Максимальная длина логина: 62 символа`)
        return false
    }

    let pass = document.getElementById("auth-pass").value
    if(pass.length < 5)
    {
        window.alert(`Минимальная длина пароля: 5 символов`)
        return false
    }
}

function validateRegistrForm()
{
    let email = document.getElementById("reg-email").value
    if(email.length === 0)
    {
        window.alert(`Поле "Email" не может быть пустым!`)
        return false
    }
    at=email.indexOf("@")
    dot=email.indexOf(".")
    if (at<1 || dot <1){
        window.alert(`Некорректно заполнено поле "Email"`)
        return false;
    }
    if((email.length) > 62)
    {
        window.alert(`Максимальная допустимая длина почты: 62 символа`)
        return false
    }

    let user = document.getElementById("reg-login").value
    if((user.length) === 0 || !user.match(/^[a-zA-Z0-9]+$/))
    {
        window.alert(`Логин должен содержать только буквы латинского алфавита и цифры`)
        return false
    }
    if((user.length) > 62)
    {
        window.alert(`Максимальная длина логина: 62 символа`)
        return false
    }

    let pass = document.getElementById("reg-pass").value
    if(pass.length < 5)
    {
        window.alert(`Минимальная длина пароля: 5 символов`)
        return false
    }
}