// Initialize the cart from localStorage or create a new cart
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Function to add a product to the cart
function addToCart(productName, price) {
    const existingItem = cart.find(item => item.name === productName);
    
    if (existingItem) {
        existingItem.quantity += 1; // Increase quantity if item already exists
    } else {
        cart.push({ name: productName, price: price, quantity: 1 }); // Add new item to cart
    }

    localStorage.setItem('cart', JSON.stringify(cart)); // Save cart to localStorage
    alert('Product added to cart!');
    updateCartPopup();
}

// Function to update cart popup content
function updateCartPopup() {
    const cartItemsList = document.getElementById('cartItemsList');
    const cartTotal = document.getElementById('cartTotal');
    const cartCount = document.getElementById('cart-count');

    cartItemsList.innerHTML = ''; // Clear current items

    let total = 0;
    cart.forEach((item, index) => {
        total += item.price * item.quantity;

        const li = document.createElement('li');
        li.classList.add('list-group-item');
        li.innerHTML = `
            ${item.name} - Rs. ${(item.price * item.quantity).toFixed(2)}
            <div class="quantity">
                <button class="btn btn-sm btn-light" onclick="changeQuantity(${index}, -1)">-</button>
                <span>${item.quantity}</span>
                <button class="btn btn-sm btn-light" onclick="changeQuantity(${index}, 1)">+</button>
            </div>
        `;
        cartItemsList.appendChild(li);
    });

    cartTotal.textContent = `Rs. ${total.toFixed(2)}`;
    cartCount.textContent = cart.length;
}

// Function to change quantity of an item in the cart
function changeQuantity(index, delta) {
    cart[index].quantity += delta;

    if (cart[index].quantity <= 0) {
        cart.splice(index, 1); // Remove item if quantity drops to zero
    }

    localStorage.setItem('cart', JSON.stringify(cart)); // Save updated cart to localStorage
    updateCartPopup();
}

// Function to clear the cart (for future use)
function clearCart() {
    cart = [];
    localStorage.removeItem('cart'); // Clear from localStorage
    updateCartPopup();
}

// Function to toggle the cart popup
function toggleCartPopup() {
    const cartPopup = document.getElementById('cartPopup');
    cartPopup.style.display = cartPopup.style.display === 'block' ? 'none' : 'block';
}

// Event listener for "Add to Cart" buttons
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', (event) => {
        const productCard = event.target.closest('.product');
        const productName = productCard.querySelector('h3').textContent;
        const price = parseFloat(productCard.querySelector('.price').textContent.replace('Rs.', ''));

        addToCart(productName, price);
    });
});

// Load cart items when page loads
document.addEventListener('DOMContentLoaded', updateCartPopup);
