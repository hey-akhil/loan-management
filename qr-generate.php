<?php
require __DIR__ . '/vendor/autoload.php'; // Correct path for Composer's autoload

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// Fetch user inputs from request
$upi_id = isset($_GET['upi_id']) ? $_GET['upi_id'] : "payee@bank";
$payee = isset($_GET['payee']) ? $_GET['payee'] : "John Doe";
$amount = isset($_GET['amount']) ? $_GET['amount'] : "1000";
$note = isset($_GET['note']) ? $_GET['note'] : "Loan-Payment";

// Generate UPI Payment URL
$upi_link = "upi://pay?pa=$upi_id&pn=" . urlencode($payee) . "&am=" . urlencode($amount) . "&cu=INR&tn=" . urlencode($note);

// QR Code Options
$options = new QROptions([
    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
    'eccLevel' => QRCode::ECC_L,
    'imageBase64' => false, // Set to true if you want base64 encoding
    'scale' => 5 // Adjust size as needed
]);

// Generate QR Code
header('Content-Type: image/png');
echo (new QRCode($options))->render($upi_link);
?>
