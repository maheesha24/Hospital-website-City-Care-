document.getElementById('payment-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    var cardNumber = document.getElementById('cardNumber').value;
    var cardExpiry = document.getElementById('cardExpiry').value;
    var cardCVC = document.getElementById('cardCVC').value;
    var cardName = document.getElementById('cardName').value;

    var hasError = false;

    // Clear previous error messages
    clearErrors();

    // Validate Card Number
    if (!/^\d{4} \d{4} \d{4} \d{4}$/.test(cardNumber)) {
        showError('cardNumberError', 'Invalid card number. Please enter in the format 1234 1234 1234 1234.');
        hasError = true;
    }

    // Validate Expiry Date
    if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(cardExpiry)) {
        showError('cardExpiryError', 'Invalid expiry date. Please enter in MM/YY format.');
        hasError = true;
    }

    // Validate CVC
    if (!/^\d{3}$/.test(cardCVC)) {
        showError('cardCVCError', 'Invalid CVC. Please enter a 3-digit code.');
        hasError = true;
    }

    // Validate Cardholder Name
    if (cardName.trim() === '') {
        showError('cardNameError', 'Cardholder name is required.');
        hasError = true;
    }

    // If no errors, submit the form (you can replace this with actual form submission logic)
    if (!hasError) {
        // Form submission logic here
        alert('Payment submitted successfully!');
    }
});

function clearErrors() {
    document.getElementById('cardNumberError').textContent = '';
    document.getElementById('cardExpiryError').textContent = '';
    document.getElementById('cardCVCError').textContent = '';
    document.getElementById('cardNameError').textContent = '';
}

function showError(elementId, message) {
    var errorElement = document.getElementById(elementId);
    errorElement.textContent = message;
    errorElement.style.display = 'block';
}

// Format card number with spaces
document.getElementById('cardNumber').addEventListener('input', function() {
    var cardNumber = this.value.replace(/\s+/g, ''); // Remove all spaces
    var formattedCardNumber = cardNumber.match(/.{1,4}/g); // Split into chunks of 4
    if (formattedCardNumber) {
        this.value = formattedCardNumber.join(' '); // Join chunks with a space
    }
    
    var cardTypeIcon = document.getElementById('card-type-icon');
    if (/^4/.test(cardNumber)) {
        cardTypeIcon.src = 'https://img.icons8.com/color/48/000000/visa.png'; // Visa
    } else if (/^5[1-5]/.test(cardNumber)) {
        cardTypeIcon.src = 'https://img.icons8.com/color/48/000000/mastercard.png'; // MasterCard
    } else if (/^3[47]/.test(cardNumber)) {
        cardTypeIcon.src = 'https://img.icons8.com/color/48/000000/amex.png'; // Amex
    } else if (/^6/.test(cardNumber)) {
        cardTypeIcon.src = 'https://img.icons8.com/color/48/000000/discover.png'; // Discover
    } else {
        cardTypeIcon.src = 'https://img.icons8.com/ios-filled/24/ffffff/bank-card-back-side.png'; // Default icon
    }
});

// Format expiry date with a '/'
document.getElementById('cardExpiry').addEventListener('input', function() {
    var expiryDate = this.value.replace(/\D/g, ''); // Remove non-digit characters
    var formattedExpiryDate = expiryDate.match(/.{1,2}/g); // Split into chunks of 2
    if (formattedExpiryDate) {
        this.value = formattedExpiryDate.join('/').slice(0, 7); // Join chunks with '/' and limit length
    }
});
