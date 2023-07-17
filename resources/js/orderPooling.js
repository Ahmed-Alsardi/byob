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

    console.log('orderPooling.js loaded');

    Echo.private(`order`)
        .listen('.order.update', (e) => {
            let container = $("#orders-container")
            container.empty()
            const BURGER_PRICE = 1000
            e.orders.forEach(order => {
                let orderDiv = createOrder(
                    order.id,
                    order.total_price / BURGER_PRICE,
                    order.total_price,
                    order.status
                )
                container.append(orderDiv)
            })
        });
})
