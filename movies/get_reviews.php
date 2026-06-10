<?php
$conn = new mysqli("localhost", "root", "", "movie_ticket_db");
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

$result = $conn->query("SELECT r.rating, r.comment, m.title AS movie FROM reviews r JOIN movies m ON r.movie_id = m.id");
$reviews = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($reviews);

$conn->close();
?>