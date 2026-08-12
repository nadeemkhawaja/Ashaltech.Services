<?php
// Contact form handler — Ashaltech Services
// Requires PHP 7.4+ (Hostinger default). Sends inquiries to info@ashaltech.io.

header('Content-Type: application/json');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

// Honeypot: real users never fill this hidden field
if (!empty($_POST['website'])) {
    echo json_encode(['ok' => true]);
    exit;
}

// Strip CR/LF to block mail-header injection
$clean = fn($v) => trim(str_replace(["\r", "\n"], ' ', (string) $v));

$name    = $clean($_POST['name'] ?? '');
$company = $clean($_POST['company'] ?? '');
$email   = $clean($_POST['email'] ?? '');
$service = $clean($_POST['service'] ?? '');
$message = trim((string) ($_POST['message'] ?? ''));

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Please provide a valid name and email.']);
    exit;
}

$to      = 'info@ashaltech.io';
$subject = 'Website inquiry — ' . ($service !== '' ? $service : 'General');
$body    = "New inquiry from the Ashaltech Services website\n\n"
         . "Name:    $name\n"
         . "Company: $company\n"
         . "Email:   $email\n"
         . "Service: $service\n\n"
         . "Message:\n$message\n";

// From must be a mailbox on your Hostinger domain for reliable delivery
$headers = "From: Ashaltech Website <no-reply@ashaltech.io>\r\n"
         . "Reply-To: $email\r\n"
         . "X-Mailer: PHP/" . phpversion();

if (@mail($to, $subject, $body, $headers)) {
    echo json_encode(['ok' => true]);
} else {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Mail could not be sent.']);
}
