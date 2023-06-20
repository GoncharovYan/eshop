function modifyCart(id, change)
{
    const addParams = {
        id: id,
        change: change,
        price: 0,
    };

    fetch(`/order/modify/`,
        {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(addParams),
        })
        .then((response) =>
        {
            return response.json();
        })
        .then((data) =>
        {
            let count = parseInt(data['count']);
            let change = parseInt(data['change']);

            // if we delete last item from cart
            if (count === 0)
            {
                button.innerHTML = 'В корзину';
                button.classList.remove("button_active");
                button.addEventListener('click', countIncrease);

                wrapper.removeChild(minus);
                wrapper.removeChild(counter);
                wrapper.removeChild(plus);
            }
            //if we add first item to cart
            else if (count - change === 0)
            {
                button.innerHTML = 'В корзине';
                button.classList.add("button_active");

                wrapper.appendChild(minus);
                wrapper.appendChild(counter);
                wrapper.appendChild(plus);

                counter.innerHTML = data['count'];
            }
            else
            {
                counter.innerHTML = data['count'];
            }
        });
}

function countIncrease()
{
    modifyCart(id, 1);
}

function countDecrease()
{
    modifyCart(id, -1);
}

const data = document.getElementById("data");
const wrapper = data.parentNode;

const id = data.dataset.id;
const initialCount = data.dataset.count;

let button = document.createElement('div');
button.classList.add("button")

let minus = document.createElement('div');
let counter = document.createElement('div');
let plus = document.createElement('div');

minus.innerHTML = '-';
counter.innerHTML = initialCount;
plus.innerHTML = '+';

minus.classList.add('counter');
counter.classList.add('count');
plus.classList.add('counter');

minus.addEventListener('click', countDecrease);
plus.addEventListener('click', countIncrease);

wrapper.appendChild(button);

if (initialCount < 1)
{
    button.innerHTML = 'В корзину';
    button.addEventListener('click', countIncrease);
}
else
{
    button.innerHTML = 'В корзине';
    button.classList.add("button_active");

    wrapper.appendChild(minus);
    wrapper.appendChild(counter);
    wrapper.appendChild(plus);
}