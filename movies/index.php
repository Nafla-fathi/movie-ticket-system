<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login/index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Ticket Management</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
   
   <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f0f2f5;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        header {
            text-align: center;
            padding: 20px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4);
            color: white;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .switch-buttons {
            margin: 15px 0;
        }

        .tab-btn {
            padding: 12px 25px;
            margin: 0 5px;
            border: none;
            border-radius: 25px;
            background-color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab-btn:hover {
            background-color: #ff6b6b;
            color: white;
        }

        .tab-content {
            display: none;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        #movies {
            padding: 0;
        }

        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .movie {
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .movie:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .movie img {
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .movie a {
            color: #ff6b6b;
            text-decoration: none;
        }

        .movie a:hover {
            text-decoration: underline;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 12px 25px;
            background-color: #ff6b6b;
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #e55a5a;
        }

        #totalAmount {
            margin: 20px 0;
            font-size: 1.3em;
            color: #ff6b6b;
            text-align: center;
        }

        .booking-details {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            background-color: #f9f9f9;
        }

        #searchBar {
            margin: 20px;
            padding: 10px;
            width: calc(100% - 40px);
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .review { border: 1px solid #ddd; padding: 10px; margin: 10px 0; background: #f9f9f9; }

        @media (max-width: 768px) {
            .movie-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Movie Ticket Management System</h1>
        <div class="switch-buttons">
            <button class="tab-btn" onclick="switchTab('movies')">Movies</button>
            <button class="tab-btn" onclick="switchTab('book')">Book Now</button>
            <button class="tab-btn" onclick="switchTab('activity')">Activity</button>
            <button class="tab-btn" onclick="switchTab('reviews')">Reviews</button>
        </div>
    </header>
    <main>
        <section id="movies" class="tab-content">
            <input type="text" id="searchBar" placeholder="Search movies...">
            <div class="movie-grid">
                <div class="movie">
                    <h3>Dune: Part Two</h3>
                    <img src="img1.png" alt="Dune Part Two" width="200">
                    <p><a href="https://www.youtube.com/watch?v=Way9Dexny3w" target="_blank">Watch Trailer</a></p>
                </div>
                <div class="movie">
                    <h3>Godzilla x Kong</h3>
                    <img src="img2.png" alt="Godzilla x Kong" width="200">
                    <p><a href="https://youtu.be/qqrpMRDuPfc?si=FFeJCD_sFJx4RyEY" target="_blank">Watch Trailer</a></p>
                </div>
                <div class="movie">
                    <h3>Deadpool & Wolverine</h3>
                    <img src="img3.png" alt="Deadpool & Wolverine" width="200">
                    <p><a href="https://youtu.be/73_1biulkYk?si=MjVjLuKdMolz6zB5" target="_blank">Watch Trailer</a></p>
                </div>
                <div class="movie">
                    <h3>Spider-Man: Beyond</h3>
                    <img src="img4.png" alt="Spider-Man: Beyond" width="200">
                    <p><a href="https://youtu.be/G8_LfOwtWew?si=qohl5fxS77gPGOOi" target="_blank">Watch Trailer</a></p>
                </div>
                <div class="movie">
                    <h3>Inside Out 2</h3>
                    <img src="img5.png" alt="Inside Out 2" width="200">
                    <p><a href="https://youtu.be/LEjhY15eCx0?si=o4Jx9GRDUicPvU4l" target="_blank">Watch Trailer</a></p>
                </div>
                <div class="movie">
                    <h3>Furiosa</h3>
                    <img src="img6.png" alt="Furiosa" width="200">
                    <p><a href="https://youtu.be/XJMuhwVlca4?si=0kvpDhpLbrTTf1Iv" target="_blank">Watch Trailer</a></p>
                </div>
                <div class="movie">
                    <h3>The Marvels</h3>
                    <img src="img7.png" alt="The Marvels" width="200">
                    <p><a href="https://youtu.be/uwmDH12MAA4?si=veKpWGAkbbgQ7o-I" target="_blank">Watch Trailer</a></p>
                </div>
                <div class="movie">
                    <h3>Oppenheimer</h3>
                    <img src="img8.png" alt="Oppenheimer" width="200">
                    <p><a href="https://youtu.be/2CXFpWTxS3M?si=3ZhsQFJLWQKbIAU6" target="_blank">Watch Trailer</a></p>
                </div>
                <div class="movie">
                    <h3>The Batman: Part II</h3>
                    <img src="img9.png" alt="The Batman: Part II" width="200">
                    <p><a href="https://youtu.be/KdA82prVlAw?si=ryHG1S55Jknb4we6" target="_blank">Watch Trailer</a></p>
                </div>
                <div class="movie">
                    <h3>Mission: Impossible</h3>
                    <img src="img10.png" alt="Mission: Impossible" width="200">
                    <p><a href="https://youtu.be/avz06PDqDbM?si=Vi4IFatyo-WY93JR" target="_blank">Watch Trailer</a></p>
                </div>
            </div>
        </section>

        <section id="book" class="tab-content">
            <h2>Book Your Movie Ticket</h2>
            <form id="bookingForm">
                <label for="movie">Select Movie:</label>
                <select id="movie" name="movie" required>
                    <option value="">Select a Movie</option>
                    <option value="Dune: Part Two">Dune: Part Two</option>
                    <option value="Godzilla x Kong: The New Empire">Godzilla x Kong: The New Empire</option>
                    <option value="Deadpool & Wolverine">Deadpool & Wolverine</option>
                    <option value="Spider-Man: Beyond the Spider-Verse">Spider-Man: Beyond the Spider-Verse</option>
                    <option value="Inside Out 2">Inside Out 2</option>
                    <option value="Furiosa: A Mad Max Saga">Furiosa: A Mad Max Saga</option>
                    <option value="The Marvels">The Marvels</option>
                    <option value="Oppenheimer">Oppenheimer</option>
                    <option value="The Batman: Part II">The Batman: Part II</option>
                    <option value="Mission: Impossible – Dead Reckoning Part Two">Mission: Impossible – Dead Reckoning Part Two</option>
                </select>
                <label for="theater">Select Theater:</label>
                <select id="theater" name="theater" required>
                    <option value="">Select a Theater</option>
                    <option value="Moviemax Circle">Moviemax Circle</option>
                    <option value="Carnival Cinemas">Carnival Cinemas</option>
                    <option value="Krishna Theatre">Krishna Theatre</option>
                    <option value="Cine Krishna Theatre">Cine Krishna Theatre</option>
                    <option value="Mehaboob A/c Theater">Mehaboob A/c Theater</option>
                    <option value="Narthalu Theater">Narthalu Theater</option>
                    <option value="Saulat Theater">Saulat Theater</option>
                    <option value="Roopesh Theater">Roopesh Theater</option>
                    <option value="Sree Krishna Theater">Sree Krishna Theater</option>
                    <option value="Pakkanar Theatre">Pakkanar Theatre</option>
                </select>
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
                <label for="showtime">Select Showtime:</label>
                <select id="showtime" name="showtime" required>
                    <option value="">Select a Showtime</option>
                    <option value="10:00 am - 1:00 pm">10:00 am - 1:00 pm</option>
                    <option value="1:10 pm - 4:10 pm">1:10 pm - 4:10 pm</option>
                    <option value="4:20 pm - 7:20 pm">4:20 pm - 7:20 pm</option>
                    <option value="7:30 pm - 10:30 pm">7:30 pm - 10:30 pm</option>
                </select>
                <label for="seats">Number of Seats (Max: 30):</label>
                <input type="number" id="seats" name="seats" min="1" max="30" required>
                <button type="submit">Book Now</button>
            </form>
        </section>

        <section id="activity" class="tab-content">
            <h2>Your Booked Tickets</h2>
            <div id="activityList">No Activity</div>
        </section>

        <section id="payment" class="tab-content" style="display:none;">
            <h2>Payment Details</h2>
            <div id="totalAmount"></div>
            <form id="paymentForm">
                <label for="cardNumber">Card Number:</label>
                <input type="text" id="cardNumber" name="cardNumber" placeholder="XXXX-XXXX-XXXX-XXXX" required>
                <label for="expDate">Expiration Date:</label>
                <input type="month" id="expDate" name="expDate" required>
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" placeholder="CVV" required>
                <button type="submit">Pay Now</button>
                <button type="button" id="cancelPayment">Cancel Payment</button>
            </form>
        </section>

        <section id="reviews" class="tab-content">
            <h2>Movie Reviews</h2>
            <div id="review-list"></div>
            <div class="review-form">
                <h3>Add Review</h3>
                <select id="review-movie" name="review-movie" required>
                    <option value="">Select a Movie</option>
                    <option value="Dune: Part Two">Dune: Part Two</option>
                    <option value="Godzilla x Kong: The New Empire">Godzilla x Kong: The New Empire</option>
                    <option value="Deadpool & Wolverine">Deadpool & Wolverine</option>
                    <option value="Spider-Man: Beyond the Spider-Verse">Spider-Man: Beyond the Spider-Verse</option>
                    <option value="Inside Out 2">Inside Out 2</option>
                    <option value="Furiosa: A Mad Max Saga">Furiosa: A Mad Max Saga</option>
                    <option value="The Marvels">The Marvels</option>
                    <option value="Oppenheimer">Oppenheimer</option>
                    <option value="The Batman: Part II">The Batman: Part II</option>
                    <option value="Mission: Impossible – Dead Reckoning Part Two">Mission: Impossible – Dead Reckoning Part Two</option>
                </select>
                <label for="rating">Rating (1-5):</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required>
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment"></textarea> <!-- Added closing tag and attributes -->
                <button onclick="submitReview()">Submit</button>
            </div>
        </section>
    </main>

    <script>
        let bookingDetails = null;
        let bookings = [];

        // Comment from Fathima Ashraf, [07-04-2025 21:50]
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });
            document.getElementById(tabId).style.display = 'block';
            if (tabId === 'reviews') loadReviews(); // Load reviews when switching to reviews tab
        }

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const movie = document.getElementById('movie').value;
            const theater = document.getElementById('theater').value;
            const date = document.getElementById('date').value; // Added date
            const showtime = document.getElementById('showtime').value;
            const seats = parseInt(document.getElementById('seats').value);
            const total = seats * 100;

            if (!movie || !theater || !date || !showtime) {
                alert('Please fill all fields.');
                return;
            }

            bookingDetails = { movie, theater, date, showtime, seats, total };
            document.getElementById('totalAmount').innerHTML = 
                `Total Amount: $${total} (${seats} seats x $100)`;
            switchTab('payment');
        });

        // Payment form submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (bookingDetails) {
                fetch('save_booking.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `movie=${encodeURIComponent(bookingDetails.movie)}&theater=${encodeURIComponent(bookingDetails.theater)}&seats=${bookingDetails.seats}&date=${encodeURIComponent(bookingDetails.date)}&slot=${encodeURIComponent(bookingDetails.showtime)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Booking confirmed! Enjoy your movie!');
                        updateActivityList();
                        switchTab('activity');
                        bookingDetails = null;
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('An error occurred: ' + error.message);
                });
            }
        });

        // Update activity list (fetch from backend)
        function updateActivityList() {
            const username = '<?php echo $_SESSION['username']; ?>';
            fetch(`get_bookings.php?username=${encodeURIComponent(username)}`)
            .then(response => response.json())
            .then(data => {
                const activityList = document.getElementById('activityList');
                if (!data || !data.length) {
                    activityList.innerHTML = 'No Activity';
                    return;
                }
                activityList.innerHTML = data.map(booking => `
                    <div class="booking-details">
                        <h3>Booking Confirmed</h3>
                        <p>Movie: ${booking.movie || 'N/A'}</p>
                        <p>Theater: ${booking.theater || 'N/A'}</p>
                        <p>Seats: ${booking.seats || booking.seats_booked || 'N/A'}</p>
                        <p>Date: ${booking.date || 'N/A'}</p>
                        <p>Time: ${booking.slot || 'N/A'}</p>
                        <p>Total Paid: $${booking.total || (booking.seats_booked * 100) || 'N/A'}</p>
                    </div>
                `).join('');
            })
            .catch(error => {
                activityList.innerHTML = 'Error loading activity: ' + error.message;
            });
        }

        // Movie search functionality
        document.getElementById('searchBar').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.movie').forEach(movie => {
                const title = movie.querySelector('h3').textContent.toLowerCase();
                movie.style.display = title.includes(searchTerm) ? 'block' : 'none';
            });
        });

        // Load reviews
        function loadReviews() {
            fetch('get_reviews.php')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    const reviewList = document.getElementById('review-list');
                    if (!data || !data.length) {
                        reviewList.innerHTML = 'No reviews available.';
                        return;
                    }
                    reviewList.innerHTML = data.map(r => `
                        <div class="review">Rating: ${r.rating}/5<br>${r.comment || 'No comment'}</div>
                    `).join('');
                })
                .catch(error => {
                    document.getElementById('review-list').innerHTML = 'Error loading reviews: ' + error.message;
                });
        }

        // Submit review
        function submitReview() {
            const movie = document.getElementById('review-movie').value;
            const rating = document.getElementById('rating').value;
            const comment = document.getElementById('comment').value;

            if (!movie || !rating) {
                alert('Please select a movie and provide a rating.');
                return;
            }

            fetch('add_review.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `movie=${encodeURIComponent(movie)}&rating=${rating}&comment=${encodeURIComponent(comment || '')}`
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    loadReviews();
                    alert('Review submitted!');
                    document.getElementById('rating').value = '';
                    document.getElementById('comment').value = '';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => alert('An error occurred: ' + error.message));
        }

        // Set default tab and initialize
        document.addEventListener('DOMContentLoaded', function() {
            switchTab('movies');
        });
    </script>
</body>
</html>