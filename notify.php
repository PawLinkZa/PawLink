<?php
// Read POST data from PayFast
$data = file_get_contents("php://input");
$post_data = [];
parse_str($data, $post_data);

// Validate PayFast's notification (adjust as per your logic)
$valid_signature = $post_data['signature'] === md5(http_build_query($post_data) . '&passphrase=YOUR_PASSPHRASE');
$payment_successful = ($post_data['payment_status'] === 'COMPLETE');

if ($valid_signature && $payment_successful) {
    // Update order status in your database
    file_put_contents('success.log', "Payment received: " . print_r($post_data, true));
} else {
    // Handle invalid notification
    file_put_contents('error.log', "Invalid notification: " . print_r($post_data, true));
}
