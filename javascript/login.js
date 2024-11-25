$(document).ready(function () {
  // Toggle Form
  const container = $(".container");
  const spans = $(".form-box .top span");
  const section = $("section");

  spans.each(function () {
      $(this).on("click", function (e) {
          const color = $(this).data("id");
          container.toggleClass("active");
          section.toggleClass("active");
          document.documentElement.style.setProperty("--custom", color);
      });
  });

  // Registration form submission
  $(document).ready(function () {
    // Registration form submission
    $('#register-form').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: '', // Update this to your PHP file handling the registration
            type: 'POST',
            data: $(this).serialize() + '&register=1', // Append register=1 to identify the request
            dataType: 'json',
            success: function (response) {
                var messageBox = $('#register-error');

                // Handle the response message
                if (response.status === 'success') {
                    messageBox
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .text(response.message)
                        .show();

                    // Reset the form on successful registration
                    $('#register-form')[0].reset();
                } else if (response.status === 'error') {
                    messageBox
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .text(response.errors ? formatErrors(response.errors) : response.message)
                        .show();
                }

                // Fade out the message after 5 seconds
                setTimeout(function () {
                    messageBox.fadeOut();
                }, 5000);
            },
            error: function () {
                // Handle generic AJAX error
                var messageBox = $('#register-error');
                messageBox
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .text('An error occurred. Please try again.')
                    .show();

                // Fade out the message after 5 seconds
                setTimeout(function () {
                    messageBox.fadeOut();
                }, 5000);
            }
        });
    });

    // Helper function to format validation errors
    function formatErrors(errors) {
        return Object.values(errors).join(', ');
    }
});

});
