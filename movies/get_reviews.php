<?php
header('Content-Type: application/json');

// Disable HTML errors in output
ob_clean();

$conn = new mysqli("localhost", "root", "", "movie_ticket_db");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$query = "
    SELECT r.rating, r.comment, m.title AS movie, DATE_FORMAT(r.review_date, '%Y-%m-%d') as review_date 
    FROM reviews r 
    JOIN movies m ON r.movie_id = m.id 
    ORDER BY r.review_date DESC
";

$result = $conn->query($query);

if ($result) {
    $reviews = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($reviews);
} else {
    echo json_encode(['success' => false, 'message' => 'Error fetching reviews: ' . $conn->error]);
}

$conn->close();
?>