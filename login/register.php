<?php
$conn = new mysqli("localhost", "root", "", "movie_ticket_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['new-username'];
    $password = password_hash($_POST['new-password'], PASSWORD_DEFAULT);
    $confirm_password = $_POST['confirm-password'];

    if ($_POST['new-password'] !== $confirm_password) {
        echo "<script>alert('Passwords do not match'); window.location.href='index.html';</script>";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'user')");
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Username already exists'); window.location.href='index.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>