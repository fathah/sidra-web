<?php

// Form data
$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$amount = $_POST['amount'];

// API endpoint
$url = 'https://mercury-uat.phonepe.com/enterprise-sandbox/v3/payLink/init';

// Request body
$data = [
    'name' => $name,
    'email' => $email,
    'mobile' => $mobile,
    'amount' => $amount
    // Add any additional parameters required by the API
];

// Initialize curl
$ch = curl_init();

// Set the URL
curl_setopt($ch, CURLOPT_URL, $url);

// Set the request method
curl_setopt($ch, CURLOPT_POST, 1);

// Set the request body
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Set the headers
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    // Add any additional headers if required
]);

// Return the response instead of outputting it
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($ch);

// Check for errors
if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    // Decode the response JSON string
    $responseData = json_decode($response, true);
    
    // Handle the response data
    if (isset($responseData['status']) && $responseData['status'] === 'SUCCESS') {
        // Payment link initiated successfully
        // Redirect user to the payment link or perform further actions
        $paymentLink = $responseData['data']['paymentLink']; // Example: Extract payment link from response
        header("Location: $paymentLink"); // Redirect user to the payment link
        exit;
    } else {
        // Payment link initiation failed
        // Handle the failure (e.g., display error message)
        echo 'Failed to initiate payment link: ' . $responseData['message'];
    }
}

// Close curl
curl_close($ch);
