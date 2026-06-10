<?php
session_start();
$conn = new mysqli("localhost", "root", "", "movie_ticket_db");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_title = $_POST['movie'];
    $rating = (int)$_POST['rating'];
    $comment = $_POST['comment'] ?? '';

    // Get movie_id
    $movie_query = $conn->prepare("SELECT id FROM movies WHERE title = ?");
    $movie_query->bind_param("s", $movie_title);
    $movie_query->execute();
    $movie_result = $movie_query->get_result();
    $movie = $movie_result->fetch_assoc();
    if (!$movie) {
        die(json_encode(['success' => false, 'message' => 'Movie not found']));
    }
    $movie_id = $movie['id'];

    // Insert review
    $stmt = $conn->prepare("INSERT INTO reviews (movie_id, rating, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $movie_id, $rating, $comment);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Review added successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding review: ' . $conn->error]);
    }

    $stmt->close();
    $movie_query->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>