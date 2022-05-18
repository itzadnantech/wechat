<?php
require_once('vendor/autoload.php');
require_once('config.php');

if (isset($_POST) && !empty($_POST)) {
    extract($_POST);
    $stripe = new \Stripe\StripeClient(STRIPE_SECRET_KEY);
    $intent = $stripe->paymentIntents->create(
        ['payment_method_types' => ['wechat_pay'], 'amount' => $amount, 'currency' => 'usd']
    );
    echo json_encode(array('code' => 'success', 'client_secret' => $intent->client_secret));
}
