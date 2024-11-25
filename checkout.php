<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php include 'Header.php'; ?>

<section class="checkout py-5">
    <div class="container">
        <h1 class="text-center mb-4">Checkout</h1>
        <div class="row">
            <div class="col-md-8">
                <h3 class="mb-3">Cart Summary</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="cart-summary">
                        <!-- Cart items will be dynamically added here -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Subtotal</th>
                            <td id="cart-subtotal">Rs. 0.00</td>
                        </tr>
                        <tr>
                            <th colspan="3">Shipping</th>
                            <td id="shipping-cost">Rs. 0.00</td>
                        </tr>
                        <tr>
                            <th colspan="3">Total</th>
                            <td id="cart-total">Rs. 0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="col-md-4">
                <h3 class="mb-3">Shipping Information</h3>
                <form id="checkout-form">
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" class="form-control" id="fullName" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="Enter your address" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" placeholder="Enter your city" required>
                    </div>
                    <div class="form-group">
                        <label for="postalCode">Postal Code</label>
                        <input type="text" class="form-control" id="postalCode" placeholder="Enter your postal code" required>
                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" class="form-control" id="country" placeholder="Enter your country" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" placeholder="Enter your phone number" required>
                    </div>

                    <h3 class="mt-4 mb-3">Payment Information</h3>
                    <div class="form-group">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber" placeholder="1234 1234 1234 1234" required>
                    </div>
                    <div class="form-group">
                        <label for="expiryDate">Expiry Date (MM/YY)</label>
                        <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required>
                    </div>
                    <div class="form-group">
                        <label for="cvc">CVC</label>
                        <input type="text" class="form-control" id="cvc" placeholder="123" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Place Order</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartSummary = document.getElementById('cart-summary');
        const cartSubtotal = document.getElementById('cart-subtotal');
        const cartTotal = document.getElementById('cart-total');
        const shippingCost = document.getElementById('shipping-cost');
        let subtotal = 0;

        cart.forEach(item => {
            const total = item.quantity * item.price;
            subtotal += total;

            cartSummary.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>Rs. ${item.price.toFixed(2)}</td>
                    <td>Rs. ${total.toFixed(2)}</td>
                </tr>
            `;
        });

        const shipping = 500;
        const total = subtotal + shipping;

        cartSubtotal.textContent = `Rs. ${subtotal.toFixed(2)}`;
        shippingCost.textContent = `Rs. ${shipping.toFixed(2)}`;
        cartTotal.textContent = `Rs. ${total.toFixed(2)}`;

        const form = document.getElementById('checkout-form');
        form.addEventListener('submit', (e) => {
    e.preventDefault();

    const orderDetails = {
        fullName: document.getElementById('fullName').value,
        address: document.getElementById('address').value,
        city: document.getElementById('city').value,
        postalCode: document.getElementById('postalCode').value,
        country: document.getElementById('country').value,
        phone: document.getElementById('phone').value,
        cardNumber: document.getElementById('cardNumber').value,
        expiryDate: document.getElementById('expiryDate').value,
        cvc: document.getElementById('cvc').value,
        subtotal: subtotal.toFixed(2),
        shipping: shipping.toFixed(2),
        total: total.toFixed(2),
        cartItems: JSON.stringify(cart)
    };

    fetch('place_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(orderDetails)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = 'thank-you.html';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

    });
</script>

</body>
</html>
