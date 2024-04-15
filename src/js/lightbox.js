jQuery(document).ready(function($) {
    // Handler for Swish QR code button click
    $('.swish-qr-button').on('click', function() {
        // Open the specified page in a lightbox
        openMagnificPopup('http://bollsvenskan.local/wait-for-swish/');
    });

    // Custom function to open Magnific Popup with provided URL
    function openMagnificPopup(url) {
        $.magnificPopup.open({
            items: {
                src: '<div class="mfp-content"><iframe src="' + url + '" frameborder="0" allowfullscreen></iframe></div>',
                type: 'inline'
            },
            closeBtnInside: true,
            removalDelay: 300,
            mainClass: 'mfp-fade',
            callbacks: {
                open: function() {
                    // Set the z-index of the lightbox container
                    $('.mfp-wrap').css('z-index', '99999999');
                }
            }
        });
    }
});
