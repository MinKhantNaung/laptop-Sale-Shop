$(document).ready(function () {
    // for detail minus button and plus button
    // for minus button
    $('.minus').click(function () {
        let qty = parseInt($('.quantity').val());
        if (qty > 1) {
            qty--;
            $('.quantity').val(qty);
        }
    })
    // for plus button
    $('.plus').click(function () {
        let qty = parseInt($('.quantity').val());
        if (qty < 20) {
            qty++;
            $('.quantity').val(qty);
        }
    })

    // for cart
    // Event handler for minus button click
    $('.minus-btn').click(function () {
        let row = $(this).closest('tr');
        let quantityInput = row.find('.quantity-input');
        let currentQuantity = parseInt(quantityInput.val());
        // for decreae total
        let price = row.find('.price').text();
        let priceNumber = parseFloat(price.replace('$', '')); // Remove $
        let total = row.find('#total');

        if (currentQuantity > 0) {
            quantityInput.val(currentQuantity - 1);
            // decrease total
            total.text('$' + (priceNumber * (currentQuantity - 1)).toFixed(2));
            finalCalculation();
        }
    });

    // Event handler for plus button click
    $('.plus-btn').click(function () {
        let row = $(this).closest('tr');
        let quantityInput = row.find('.quantity-input');
        let currentQuantity = parseInt(quantityInput.val());
        // for increase total
        let price = row.find('.price').text();
        let priceNumber = parseFloat(price.replace('$', '')); // Remove $
        let total = row.find('#total');

        if (currentQuantity < 20) {
            quantityInput.val(currentQuantity + 1);
            // increase total
            total.text('$' + (priceNumber * (currentQuantity + 1)).toFixed(2));
            finalCalculation();
        }
    });

    function finalCalculation() {
        // for calculate cart total
        let subtotal = $('.subtotal');
        let shipping = $('.shipping');
        const shippingCost = parseFloat(shipping.text().replace('$', ''));
        let finalTotal = $('.final-total');
        // calculate subtotal and finaltotal
        let allTotalSum = 0;
        $('#dataTable tr').each(function (index, tr) {
            allTotalSum += parseFloat($(tr).find('#total').text().replace('$', ''));
        })
        subtotal.text('$' + allTotalSum.toFixed(2));
        // for calculate final total
        let calculateFinalTotal = parseFloat(allTotalSum.toFixed(2)) + shippingCost;
        finalTotal.text('$' + calculateFinalTotal);
    }
});

