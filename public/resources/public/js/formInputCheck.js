function createElement(){
	let error = document.createElement('p');
	error.innerHTML = "Заполните обязательные поля.";
	error.className = "order-details__error";
	return error;
}


function checkInputForm()
{
	let fields = document.getElementsByClassName("form-field"), flag = 0;
	let mainDiv = document.getElementById('order-div');
	let errors = document.getElementsByClassName('order-details__error');
	let childPTag = document.getElementById('first-p-child');

	for (let field of fields)
	{
		if (field.value === '' && 'Comment' !== field.placeholder)
		{
			flag = 1;
		}
	}

	if (flag === 1)
	{
		if(errors.length > 0){
			errors = errors.item(0);
		}
		else
		{
			childPTag.parentNode.insertBefore(createElement(), childPTag.nextSibling);
		}
		console.log(errors);
		return false;
	}

}
