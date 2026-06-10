<?php
session_start();

if (!isset($_SESSION['username'])) {
    die(json_encode(['success' => false, 'message' => 'User not logged in']));
}

$conn = new mysqli("localhost", "root", "", "movie_ticket_db");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

$username = $_SESSION['username'];
$stmt = $conn->prepare("
    SELECT b.*, m.title AS movie 
    FROM bookings b 
    JOIN users u ON b.user_id = u.id 
    JOIN movies m ON b.movie_id = m.id 
    WHERE u.username = ?
");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($bookings);

$stmt->close();
$conn->close();
?>