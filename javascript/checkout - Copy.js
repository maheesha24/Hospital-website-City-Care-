document.addEventListener('DOMContentLoaded', () => {
    // Retrieve cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let subtotal = 0;
    const cartSummary = document.getElementById('cart-summary');
    const cartSubtotal = document.getElementById('cart-subtotal');
    const cartTotal = document.getElementById('cart-total');
    const shippingCost = document.getElementById('shipping-cost');

    // Loop through cart items and display them
    cart.forEach((item, index) => {
        const total = item.quantity * item.price;
        subtotal += total;

        cartSummary.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>
                    <input type="number" class="form-control" value="${item.quantity}" data-product-name="${item.name}" min="1" onchange="updateQuantity('${item.name}', this.value)">
                </td>
                <td>Rs. ${item.price.toFixed(2)}</td>
                <td class="item-total" id="total-${index}">Rs. ${total.toFixed(2)}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="removeFromCart(${index})">Remove</button>
                </td>
            </tr>
        `;
    });

    // Add shipping cost (for example, Rs. 500)
    const shipping = 500;
    const total = subtotal + shipping;

    // Update totals with fixed decimal places
    cartSubtotal.textContent = `Rs. ${subtotal.toFixed(2)}`;
    shippingCost.textContent = `Rs. ${shipping.toFixed(2)}`;
    cartTotal.textContent = `Rs. ${total.toFixed(2)}`;
});

// Function to update quantity
function updateQuantity(productName, newQuantity) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    cart = cart.map(item => {
        if (item.name === productName) {
            return { ...item, quantity: parseInt(newQuantity) };
        }
        return item;
    });

    // Update cart in localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    // Refresh the page to update the totals
    window.location.reload();
}

// Function to remove an item from the cart
function removeFromCart(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Remove the item at the specified index
    cart.splice(index, 1);

    // Update cart in localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    // Refresh the page to update the cart
    window.location.reload();
}

// Card type detection
document.addEventListener('DOMContentLoaded', () => {
    const cardNumberInput = document.getElementById('cardNumber');
    const cardTypeIcon = document.getElementById('card-type-icon');
    const expiryDateInput = document.getElementById('expiryDate');
    const cvcInput = document.getElementById('cvc');
    const errorMessage = document.getElementById('error-message');

    // Card number formatting (e.g., 1234 1234 1234 1234)
    cardNumberInput.addEventListener('input', function() {
        let cardNumber = this.value.replace(/\s+/g, '').replace(/[^0-9]/g, '');
        let formattedCardNumber = cardNumber.match(/.{1,4}/g)?.join(' ') || '';
        this.value = formattedCardNumber;

        // Real-time card type detection
        detectCardType(cardNumber);
    });

    // Detect card type based on input
    function detectCardType(cardNumber) {
        cardNumber = cardNumber.replace(/\s+/g, '');

        if (/^4/.test(cardNumber)) {
            cardTypeIcon.src = 'https://img.icons8.com/color/48/000000/visa.png'; // Visa
        } else if (/^5[1-5]/.test(cardNumber)) {
            cardTypeIcon.src = 'https://img.icons8.com/color/48/000000/mastercard-logo.png'; // MasterCard
        } else if (/^3[47]/.test(cardNumber)) {
            cardTypeIcon.src = 'https://img.icons8.com/color/48/000000/amex.png'; // Amex
        } else if (/^6/.test(cardNumber)) {
            cardTypeIcon.src = 'https://img.icons8.com/color/48/000000/discover.png'; // Discover
        } else {
            cardTypeIcon.src = 'https://img.icons8.com/ios-filled/24/ffffff/bank-card-back-side.png'; // Default icon
        }
    }

    // Expiry date validation (MM/YY format)
    expiryDateInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9/]/g, '');
        if (this.value.length === 2 && !this.value.includes('/')) {
            this.value += '/';
        }
    });

    // Form submission with error handling
    document.getElementById('checkout-form').addEventListener('submit', function(event) {
        event.preventDefault();
        errorMessage.innerHTML = ''; // Clear previous errors

        let cardNumber = cardNumberInput.value.replace(/\s+/g, '');
        let expiryDate = expiryDateInput.value;
        let cvc = cvcInput.value;

        // Validate card number (dummy length check, can be improved with Luhn algorithm)
        if (cardNumber.length < 16) {
            showError('Please enter a valid 16-digit card number.');
            return;
        }

        // Validate expiry date (basic MM/YY format check)
        if (!/^\d{2}\/\d{2}$/.test(expiryDate)) {
            showError('Please enter a valid expiration date (MM/YY).');
            return;
        }

        // Validate CVC (typically 3 or 4 digits)
        if (cvc.length < 3 || cvc.length > 4) {
            showError('Please enter a valid CVC number (3 or 4 digits).');
            return;
        }

        // If everything is valid, save order details and redirect
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        let subtotal = 0;
        const shipping = 500; // Example shipping cost

        cart.forEach(item => {
            subtotal += item.quantity * item.price;
        });

        const total = subtotal + shipping;

        // Create order details
        const orderDetails = {
            subtotal: subtotal.toFixed(2),
            shipping: shipping.toFixed(2),
            total: total.toFixed(2),
            cartItems: cart.map(item => ({
                name: item.name,
                quantity: item.quantity,
                price: item.price.toFixed(2),
                total: (item.quantity * item.price).toFixed(2)
            }))
        };

        // Store order details in local storage
        localStorage.setItem('orderDetails', JSON.stringify(orderDetails));

        // Redirect to the Thank You page
        window.location.href = 'thank-you.html'; // Change this to your actual Thank You page URL
    });

    // Helper function to display error messages
    function showError(message) {
        errorMessage.innerHTML = `<div class="alert alert-danger">${message}</div>`;
    }
});
