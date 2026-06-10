let bookingDetails = null;

function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
    document.getElementById(tabId).style.display = 'block';
    if (tabId === 'activity') updateActivityList();
    if (tabId === 'reviews') loadReviews();
}

document.getElementById('bookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const movie = document.getElementById('movie').value;
    const theater = document.getElementById('theater').value;
    const seats = parseInt(document.getElementById('seats').value);
    const date = document.getElementById('date').value;
    const showtime = document.getElementById('showtime').value;
    const total = seats * 100;

    if (!movie || !theater || !date || !showtime) {
        alert('Please fill all fields.');
        return;
    }

    bookingDetails = { movie, theater, seats, date, slot: showtime, total };
    document.getElementById('totalAmount').innerHTML = `Total Amount: $${total} (${seats} seats x $100)`;
    switchTab('payment');
});

document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (bookingDetails) {
        fetch('save_booking.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `movie=${encodeURIComponent(bookingDetails.movie)}&theater=${encodeURIComponent(bookingDetails.theater)}&seats=${bookingDetails.seats}&date=${encodeURIComponent(bookingDetails.date)}&slot=${encodeURIComponent(bookingDetails.slot)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Booking confirmed! Enjoy your movie!');
                switchTab('activity');
                bookingDetails = null;
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => alert('An error occurred: ' + error.message));
    }
});

document.getElementById('cancelPayment').addEventListener('click', function() {
    switchTab('book');
    bookingDetails = null;
});

function updateActivityList() {
    fetch('get_bookings.php')
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
                <p>Seats: ${booking.seats || 'N/A'}</p>
                <p>Date: ${booking.date || 'N/A'}</p>
                <p>Time: ${booking.slot || 'N/A'}</p>
                <p>Total Paid: $${booking.total || 'N/A'}</p>
            </div>
        `).join('');
    })
    .catch(error => document.getElementById('activityList').innerHTML = 'Error loading activity: ' + error.message);
}

document.getElementById('searchBar').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    document.querySelectorAll('.movie').forEach(movie => {
        const title = movie.querySelector('h3').textContent.toLowerCase();
        movie.style.display = title.includes(searchTerm) ? 'block' : 'none';
    });
});

function loadReviews() {
    fetch('get_reviews.php')
    .then(response => response.json())
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
    .catch(error => document.getElementById('review-list').innerHTML = 'Error loading reviews: ' + error.message);
}

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
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `movie=${encodeURIComponent(movie)}&rating=${rating}&comment=${encodeURIComponent(comment || '')}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadReviews();
            alert('Review submitted successfully!');
            document.getElementById('review-movie').value = '';
            document.getElementById('rating').value = '';
            document.getElementById('comment').value = '';
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => alert('An error occurred: ' + error.message));
}

document.addEventListener('DOMContentLoaded', () => switchTab('movies'));