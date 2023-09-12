<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        empty($_POST["name"]) || empty($_POST["subject"]) ||
        empty($_POST["message"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)
    ) {
        http_response_code(400); // Bad Request
        echo json_encode(array("success" => false, "message" => "Invalid input data"));
        exit();
    }

    $name = strip_tags(htmlspecialchars($_POST["name"]));
    $email = strip_tags(htmlspecialchars($_POST["email"]));
    $subject = strip_tags(htmlspecialchars($_POST["subject"]));
    $message = strip_tags(htmlspecialchars($_POST["message"]));

    $to = "jayaprakash.jaisankar@fssa.freshworks.com"; // Change this to your email address
    $subject = "$subject: $name";
    $body = "You have received a new message from your website contact form.\n\n"
        . "Here are the details:\n\nName: $name\n\nEmail: $email\n\nSubject: $subject\n\nMessage: $message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        http_response_code(200); // OK
        echo json_encode(array("success" => true, "message" => "Email sent successfully"));
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(array("success" => false, "message" => "Failed to send email. Please try again later."));
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}
?>
