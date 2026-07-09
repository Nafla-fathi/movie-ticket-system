<?php
session_start();
$conn = new mysqli("localhost", "root", "", "movie_ticket_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    die(json_encode(['success' => false, 'message' => 'User not logged in']));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_title = $_POST['movie'];
    $theater = $_POST['theater'];
    $seats = (int)$_POST['seats'];
    $date = $_POST['date'];
    $today = date("Y-m-d");
    if ($date < $today) {
        echo json_encode([
            "success" => false,
            "message" => "You cannot book tickets for a past date."
        ]);
        exit();
    }
    
    $slot = $_POST['slot'];
    $total = $seats * 100;

    // Get user_id
    $username = $_SESSION['username'];
    $user_query = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $user_query->bind_param("s", $username);
    $user_query->execute();
    $user_result = $user_query->get_result();
    $user = $user_result->fetch_assoc();
    if (!$user) {
        die(json_encode(['success' => false, 'message' => 'User not found']));
    }
    $user_id = $user['id'];

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

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, movie_id, theater, seats, date, slot, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisissi", $user_id, $movie_id, $theater, $seats, $date, $slot, $total);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Booking saved successfully']);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error saving booking: ' . $conn->error]);
        exit();
    }

    $stmt->close();
    $movie_query->close();
    $user_query->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$conn->close();
?>
