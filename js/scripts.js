document.addEventListener('DOMContentLoaded', (event) => {
    const quantityElement = document.querySelector('span.quantity');
    const cartQuantity = parseInt(quantityElement.getAttribute('data-quantity'), 10);

    if (!isNaN(cartQuantity)) {
        console.log('Cart Quantity:', cartQuantity);
        quantityElement.textContent = cartQuantity;
    } else {
        console.error('Could not retrieve cart quantity');
    }
});