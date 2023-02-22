function validateAuthForm()
{
    let user = document.getElementById("auth-login").value
    if(user.length === 0)
    {
        window.alert(`Поле "Логин" не может быть пустым!`)
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
    let user = document.getElementById("reg-login").value
    if(user.length === 0)
    {
        window.alert(`Поле "Логин" не может быть пустым!`)
        return false
    }
    let pass = document.getElementById("reg-pass").value
    if(pass.length < 5)
    {
        window.alert(`Минимальная длина пароля: 5 символов`)
        return false
    }
}