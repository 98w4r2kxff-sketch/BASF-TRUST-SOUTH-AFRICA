<?php
use /src/PHPMailer;
use /src/Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = strip_tags(trim($_POST['name']));
    $email   = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST['subject']));
    $message = strip_tags(trim($_POST['message']));

    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Please fill in all fields correctly.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // TurboSMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'mail.cnwebtest.co.za';
        $mail->SMTPAuth   = true;
        $mail->Username   = '_mainaccount@cnwebtest.co.za'; // your TurboSMTP email
        $mail->Password   = 'CN_Web_Solutions@2025';                // your TurboSMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 465;

        // Sender and recipient settings
        $mail->setFrom('mail.cnwebtest.co.za', 'Website Contact Form');
        $mail->addReplyTo($email, $name);
        $mail->addAddress('molotokarabo@icloud.com', 'Website Owner');

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong><br>$message</p>
        ";

        // Send email
        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>

