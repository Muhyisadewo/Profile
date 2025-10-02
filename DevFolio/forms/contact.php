<?php
  /**
  * Simple PHP Contact Form using built-in mail() function
  * Replace contact@example.com with your real receiving email address
  */

  // Replace with your real receiving email address
  $receiving_email_address = 'contact@example.com';

  // Check if form was submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $name = isset($_POST['name']) ? strip_tags(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $subject = isset($_POST['subject']) ? strip_tags(trim($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? strip_tags(trim($_POST['message'])) : '';

    // Validate form data
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
      echo json_encode(['error' => 'Mohon isi semua kolom yang diperlukan.']);
      exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode(['error' => 'Alamat email tidak valid.']);
      exit;
    }

    // Build email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Build email headers
    $email_headers = "From: $name <$email>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($receiving_email_address, $subject, $email_content, $email_headers)) {
      echo json_encode(['success' => 'Pesan Anda telah terkirim. Terima kasih!']);
    } else {
      echo json_encode(['error' => 'Maaf! Terjadi kesalahan dan kami tidak dapat mengirim pesan Anda.']);
    }
  } else {
    echo json_encode(['error' => 'Metode permintaan tidak valid.']);
  }
?>
