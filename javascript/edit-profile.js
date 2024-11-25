document.addEventListener('DOMContentLoaded', function() {
    const profileImageInput = document.getElementById('profile-image');
    const profileImgPreview = document.getElementById('profile-img-preview');

    // Example code to set the current profile image URL (for demonstration purposes)
    // You should dynamically set this based on your application's logic
    profileImgPreview.src = 'assets/images/current-avatar.png'; // Replace with actual URL

    profileImageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImgPreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
});
