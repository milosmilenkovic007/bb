jQuery(document).ready(function($) {
    // Handle form submission
    $('#swish-payment-form').on('submit', function(e) {
        e.preventDefault();

        // Get the phone number from the form
        var phoneNumber = $('#phone-number').val();

        // AJAX request to verify phone number and generate Swish QR code
        $.ajax({
            url: ajax_object.ajax_url,
            type: 'post',
            data: {
                action: 'swish_payment',
                phone_number: phoneNumber
            },
            success: function(response) {
                // Check if AJAX request was successful
                if (response.success) {
                    // Display Swish QR code image
                    $('#swish-qr-code').html('<img src="' + response.data.qr_code + '" alt="Swish QR Code">');
                } else {
                    // Display error message if phone number verification fails
                    $('#swish-qr-code').html('<p>' + response.data + '</p>');
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX error
                console.error(xhr.responseText);
            }
        });
    });
});
