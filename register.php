<?php
session_start();
include __DIR__ . '/includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm-password"];

    if (empty($name) || empty($email) || empty($password)) {
        die("All fields required");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // IMPORTANT: MATCH YOUR TABLE
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: login.html?registered=true");
        exit();
    } else {
        die("Insert failed: " . $stmt->error);
    }
}
?>