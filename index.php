<?php require_once('config.php') ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>WeChat Pay</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="assets/css/base.css" />
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="assets/js//utils.js" defer></script>
</head>

<body>
    <!------ Include the above in your HEAD tag ---------->

    <div class="container">
        <div class="row centered-form">
            <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">WeChat Payment <small>Test here!</small></h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" id="payment-form">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="first_name" id="first_name" class="form-control input-sm" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email Address">
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <input type="number" min="50" name="amount" class="form-control input-sm" placeholder="Amount in USD">

                                </div>
                            </div>

                            <input type="submit" value="Pay Now" id="orderbtn" class="btn btn-info btn-block">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="messages" role="alert"></div>

</body>

</html>



<script>
    var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');
    var form = document.getElementById('payment-form');

    // form.addEventListener('submit', function(event) {
    //     event.preventDefault();
    //     var response = fetch('secret.php').then(function(response) {
    //         return response.json();
    //     }).then(function(responseJson) {
    //         var clientSecret = responseJson.client_secret;
    //         // Call stripe.confirmWechatPayPayment() with the client secret.
    //         // Set the clientSecret here you got in Step 2
    //         stripe.confirmWechatPayPayment(
    //             clientSecret, {
    //                 payment_method_options: {
    //                     wechat_pay: {
    //                         client: 'web',
    //                     },
    //                 }
    //             },
    //         );
    //     });


    // });
</script>

<script>
    $('#payment-form').submit(function(e) {

        e.preventDefault();
        e.stopPropagation();
        var form = $(this).serialize();
        let url = '<?php echo SERVER_ROOT . 'secret.php' ?>';
        alert(form);
        $(".error").remove();

        $.ajax({
            type: 'POST',
            url: url,
            data: form,
            dataType: 'html',
            beforeSend: function() {
                $('#orderbtn').val('Please Wait...');
                $('#orderbtn')
            },
            success: function(data) {
                let res = JSON.parse(data);
                switch (res.code) {
                    case 'success':
                        var clientSecret = res.client_secret;
                        stripe.confirmWechatPayPayment(
                            clientSecret, {
                                payment_method_options: {
                                    wechat_pay: {
                                        client: 'web',
                                    },
                                }
                            },
                        );


                    case 'warning':

                        break;

                }
            }
        });

    });

    $(document).keypress(function(e) {
        $('.error').hide();
    });
</script>