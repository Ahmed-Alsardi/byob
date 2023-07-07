$(document).ready(() => {
    function createOrder(orderId, burgerCount, totalPrice, status) {
        const $div = $('<div>').addClass('flex items-center justify-around mb-4');
        const $link = $('<a>').attr('href', 'orders/' + orderId)
            .addClass('text-blue-500 hover:underline')
            .text(orderId + ': ' + burgerCount + ' Burgers');
        const $price = $('<span>').addClass('text-gray-500').text(totalPrice + " cents AED");
        const $status = $('<span>').addClass('text-gray-500').text(status);

        $div.append($link, $price, $status);
        return $div;
    }

    const updateOrders = () => {
        fetch("/orders?api=true")
            .then(res => res.json())
            .then(data => {
                let container = $("#orders-container")
                container.empty()
                const BURGUER_PRICE = 1000
                data.orders.forEach(order => {
                    let orderDiv = createOrder(
                        order.id,
                        order.total_price / BURGUER_PRICE,
                        order.total_price,
                        order.status
                    )
                    container.append(orderDiv)
                })
            })
    }
    setInterval(updateOrders, 1000)
})
