<?php
if (isset($_POST['customer_number']) && isset($_POST['price'])) {
    $url = "https://mpc.getswish.net/qrg-swish/api/v1/prefilled";
    $payload = '{"format":"png","size":300,"message":{"value":"Swish payment"},"amount":{"value":' . $_POST['price'] . ',"editable":false},"payee":{"value":"' . $_POST['customer_number'] . '","editable":true}}';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <title>Swish QR</title>
</head>
<body>
<div class="container">
    <?php if (!isset($result)) : ?>
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-4">

                <form method=post>
                    <div class="form-group">
                        <label for="customer_number">Customer Number</label>
                        <input name="customer_number" type="text" class="form-control" id="customer_number"
                               placeholder="Customer Number..."
                               value="<?php echo isset($_POST['customer_number']) ? $_POST['customer_number'] : ""; ?>"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input name="price" type="number" class="form-control" id="price"
                               placeholder="Price in SEK..."
                               value="<?php echo isset($_POST['price']) ? $_POST['price'] : ""; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Swish QR Code</button>
                </form>
            </div>
        </div>
    <?php else : ?>
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-4 text-align-center">
                <div class="card">
                    <h5 class="card-header text-center">
                        <strong>Swish Payment Details</strong>
                    </h5>
                    <div class="card-body">
                        <?php echo "<img src='data:image/png;base64," . base64_encode($result) . "'>"; ?>
                        <br>
                    </div>
                    <h3 class="card-footer bg-white text-center">
                        <?php echo "Amount: " . $_POST['price'] . " SEK"; ?>
                    </h3>
                </div>
                <a href="/" class="btn btn-light mt-3">Back</a>
            </div>
        </div>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>
