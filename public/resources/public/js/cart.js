function modifyCart(id, price, change = 1)
{
    const addParams = {
        id: id,
        change: change,
        price: price,
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
            const itemCount = document.getElementById(`item-id-${data['id']}-count`);
            const itemPrice = document.getElementById(`item-id-${data['id']}-price`);
            const total = document.getElementById('total');

            if (parseInt(itemCount.innerHTML) + data['change'] < 1)
            {
                const item = document.getElementById(`item-id-${data['id']}`);

                const parent = item.parentNode;
                parent.removeChild(item);
                return;
            }
            itemCount.innerHTML = parseInt(itemCount.innerHTML) + parseInt(data['change']);
            itemPrice.innerHTML = parseInt(itemPrice.innerHTML) + parseInt(data['change']) * parseInt(data['price']);
            total.innerHTML = parseInt(total.innerHTML) + parseInt(data['change']) * parseInt(data['price']);
        })
}

function deleteFromCart(id, price)
{
    const addParams = {
        id: id,
        price: price,
    };

    fetch(`/order/delete/`,
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
            const total = document.getElementById('total');
            const item = document.getElementById(`item-id-${data['id']}`);
            const itemPrice = document.getElementById(`item-id-${data['id']}-price`);

            const parent = item.parentNode;

            total.innerHTML = parseInt(total.innerHTML) - parseInt(itemPrice.innerHTML);

            parent.removeChild(item);
        })
}