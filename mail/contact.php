<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  if (empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(500);
    exit();
  }

  $conn = new mysqli("localhost", "WebISAMM", "ahmed2003", "contact");

  if ($conn->connect_error) {
    die("Connection Failed : " . $conn->connect_error);
  } else {
    echo "connected";

    $stmt = $conn->prepare("insert into form_contact (name, email, subject, message ) values (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if (!$stmt->execute()) {
      echo "Error sending message: " . $stmt->error;
    } else {
      echo "Your message has been sent.";
    }

    $stmt->close();
    $conn->close();
  }
}

