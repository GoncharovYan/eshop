function modifyCart(id, count = 1)
{
    const addParams = {
        id: id,
        count: count,
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

            if (parseInt(itemCount.innerHTML) + data['count'] < 1)
            {
                const item = document.getElementById(`item-id-${data['id']}`);

                const parent = item.parentNode;
                parent.removeChild(item);
                return;
            }
            itemCount.innerHTML = parseInt(itemCount.innerHTML) + data['count'];
        })
}

function deleteFromCart(id)
{
    const addParams = {
        id: id,
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
            const item = document.getElementById(`item-id-${data['id']}`);
            const parent = item.parentNode;

            parent.removeChild(item);
        })
}