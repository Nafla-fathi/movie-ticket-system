<?php
// Debug file - shows all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

// Check if session exists
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

// Check database connection
$conn = new mysqli("localhost", "root", "", "movie_ticket_db");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

<<<<<<< HEAD
// Check if POST data exists
if ($_SERVER["REQUEST_METHOD"] != "POST") {
=======
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
>>>>>>> 8e871fefe393eb284000c148e642e220e792450b
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

// Get POST data
$movie_title = isset($_POST['movie']) ? trim($_POST['movie']) : '';
$theater = isset($_POST['theater']) ? trim($_POST['theater']) : '';
$seats = isset($_POST['seats']) ? (int)$_POST['seats'] : 0;
$date = isset($_POST['date']) ? trim($_POST['date']) : '';
$slot = isset($_POST['slot']) ? trim($_POST['slot']) : '';

// Log received data
error_log("Received: movie=$movie_title, theater=$theater, seats=$seats, date=$date, slot=$slot");

// Validate inputs
if (empty($movie_title) || empty($theater) || $seats < 1 || empty($date) || empty($slot)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit();
}

$total = $seats * 100;
$username = $_SESSION['username'];

// Get user_id
$user_query = $conn->prepare("SELECT id FROM users WHERE username = ?");
if (!$user_query) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit();
}
$user_query->bind_param("s", $username);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    $user_query->close();
    exit();
}
$user_id = $user['id'];
$user_query->close();

// Check if movie exists
$movie_query = $conn->prepare("SELECT id FROM movies WHERE title = ?");
if (!$movie_query) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit();
}
$movie_query->bind_param("s", $movie_title);
$movie_query->execute();
$movie_result = $movie_query->get_result();
$movie = $movie_result->fetch_assoc();

if (!$movie) {
    // Insert movie
    $insert_movie = $conn->prepare("INSERT INTO movies (title) VALUES (?)");
    $insert_movie->bind_param("s", $movie_title);
    if ($insert_movie->execute()) {
        $movie_id = $insert_movie->insert_id;
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating movie: ' . $conn->error]);
        $movie_query->close();
        exit();
    }
    $insert_movie->close();
} else {
    $movie_id = $movie['id'];
}
$movie_query->close();

// Insert booking
$stmt = $conn->prepare("INSERT INTO bookings (user_id, movie_id, theater, seats_booked, date, slot, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    exit();
}

$stmt->bind_param("iisissi", $user_id, $movie_id, $theater, $seats, $date, $slot, $total);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Booking confirmed! Enjoy your movie! 🎬', 'booking_id' => $stmt->insert_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error saving booking: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
