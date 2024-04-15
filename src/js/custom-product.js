document.addEventListener('DOMContentLoaded', function () {
    var checkoutButtons = document.querySelectorAll('.stripe-checkout-button');
    
    checkoutButtons.forEach(function(button) {
        button.addEventListener('click', function () {
            var container = button.closest('.paywall-button-container');
            var selectedMethod = container.querySelector('select[name="payment-method"]').value;
            
            if (selectedMethod === 'stripe') {
                var productId = container.dataset.productId;
                var priceId = button.dataset.priceId;
                var mode = button.dataset.mode; 

                console.log('Price ID:', priceId);
                console.log('Mode:', mode);

                redirectToCheckout(productId, priceId, mode);
            }
        });
    });

    function redirectToCheckout(productId, priceId, mode) {
        var stripe = Stripe('pk_test_51HaAwtK5jB6KWDXlgteNAsz7yn0xXiA1jluSEF96XKdiDJ7daT32leXRQjyRDhTKqx6R2tANyvbNmcF3u8rK63Y200SXAwp5e0');
        
        var sessionConfig = {
            lineItems: [{ price: priceId, quantity: 1 }],
            successUrl: 'https://martin.milos.live/omgangens-elva-marcus-danielson-och-max-fenger-tar-varsin-plats-i-omgangens-elva/',
            cancelUrl: 'https://martin.milos.live',
            clientReferenceId: productId
        };

        if (mode === 'subscription') {
            sessionConfig.mode = 'subscription';
        } else {
            sessionConfig.mode = 'payment';
        }

        stripe.redirectToCheckout(sessionConfig).then(function (result) {
            if (result.error) {
                console.error(result.error.message);
            } else {
                // If the payment is successful, register and login the user
                var userEmail = result.paymentMethod.billing_details.email;
                var userName = result.paymentMethod.billing_details.name;
                registerAndLoginUser(userEmail, userName);
            }
        });
    }

    function registerAndLoginUser(email, name) {
        // Register the user
        registerUser(email, name)
            .then(function () {
                // After successful registration, auto-login the user
                autoLoginUser(email);
            })
            .catch(function (error) {
                console.error('Error registering user:', error);
            });
    }

    function registerUser(email, name) {
        return fetch('/register_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email: email, name: name })
        })
        .then(function (response) {
            if (response.ok) {
                console.log('User registered successfully');
            } else {
                throw new Error('User registration failed');
            }
        });
    }

    function autoLoginUser(email) {
        // Perform auto-login by redirecting to the WordPress login page with username and password parameters
        var temporaryPassword = generateTemporaryPassword(12);
        window.location.href = '/wp-login.php?auto_login=true&username=' + email + '&password=' + temporaryPassword;
    }

    function generateTemporaryPassword(length) {
        // Generate a temporary password for auto-login
        var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
        var temporaryPassword = "";
        for (var i = 0; i < length; i++) {
            var randomIndex = Math.floor(Math.random() * charset.length);
            temporaryPassword += charset[randomIndex];
        }
        return temporaryPassword;
    }
});
