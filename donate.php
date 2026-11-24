<?php
include __DIR__ . '/includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $email = $_POST['email'];
    $condition = $_POST['condition'];
    $description = $_POST['description'];

    // INSERT DATA
    $sql = "INSERT INTO donations (book_title, email, book_condition, description)
            VALUES ('$title', '$email', '$condition', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Book donated successfully!');
                window.location.href='donate.html';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>