<?php
session_start();
$conn = new mysqli("localhost", "root", "", "movie_ticket_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // Plaintext password from form
    $role = $_POST['role'];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ? AND role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id']; // Store user ID for later use
            session_write_close();
            header("Location: ../movies/index.php");
            exit();
        } else {
            echo "<script>alert('Invalid credentials'); window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials'); window.location.href='index.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>