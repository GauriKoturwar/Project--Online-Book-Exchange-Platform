<?php
session_start();
include __DIR__ . '/includes/db.php';

$error_message = "";

if (isset($_SESSION["user_id"])) {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $error_message = "Both fields are required.";
    } else {

        $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["name"];

            // ✅ CHANGE MADE HERE
            header("Location: index.html");
            exit();

        } else {
            $error_message = "Invalid email or password.";
        }

        $stmt->close();
    }
}
?>