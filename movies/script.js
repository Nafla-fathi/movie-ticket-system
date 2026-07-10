let bookingDetails = null;

function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
    document.getElementById(tabId).style.display = 'block';
    if (tabId === 'activity') updateActivityList();
    if (tabId === 'reviews') loadReviews();
}

// Set min and max date for booking
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date');
    const today = new Date();
    const currentMonth = today.getMonth();
    const currentYear = today.getFullYear();
    
    // Set min date to today
    const minDate = today.toISOString().split('T')[0];
    dateInput.setAttribute('min', minDate);
    
    // Set max date to end of current month
    const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0);
    const maxDate = lastDayOfMonth.toISOString().split('T')[0];
    dateInput.setAttribute('max', maxDate);
    
    // Add validation on change
    dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        if (selectedDate.getMonth() !== currentMonth || selectedDate.getFullYear() !== currentYear) {
            alert('You can only book tickets for the current month!');
            this.value = '';
        }
    });
});

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

    // Additional validation for current month
    const selectedDate = new Date(date);
    const today = new Date();
    const currentMonth = today.getMonth();
    const currentYear = today.getFullYear();
    
    if (selectedDate.getMonth() !== currentMonth || selectedDate.getFullYear() !== currentYear) {
        alert('You can only book tickets for the current month!');
        document.getElementById('date').value = '';
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
                <p><strong>Movie:</strong> ${booking.movie || 'N/A'}</p>
                <p><strong>Theater:</strong> ${booking.theater || 'N/A'}</p>
                <p><strong>Seats:</strong> ${booking.seats_booked || booking.seats || 'N/A'}</p>
                <p><strong>Date:</strong> ${booking.date || 'N/A'}</p>
                <p><strong>Time:</strong> ${booking.slot || 'N/A'}</p>
                <p><strong>Total Paid:</strong> $${booking.total || 'N/A'}</p>
            </div>
        `).join('');
    })
    .catch(error => {
        document.getElementById('activityList').innerHTML = 'Error loading activity: ' + error.message;
    });
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
            <div class="review">
                <p><strong>Movie:</strong> ${r.movie || 'N/A'}</p>
                <p><strong>Rating:</strong> ${r.rating}/5</p>
                <p><strong>Comment:</strong> ${r.comment || 'No comment'}</p>
            </div>
        `).join('');
    })
    .catch(error => {
        document.getElementById('review-list').innerHTML = 'Error loading reviews: ' + error.message;
    });
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
    .catch(error => {
        alert('An error occurred: ' + error.message);
    });
}

// Set default tab
if (document.querySelector('.tab-content')) {
    switchTab('movies');
}