<div class="product-details">
    <!-- Existing product details -->
    <?php if (!empty($row)) { ?>
        <!-- Existing product details -->
    <?php } ?>

    <!-- Booking Form -->
    <div class="booking-form">
        <h2>Book This Car</h2>
        <form action="bookCar.php" method="POST">
            <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($id); ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required><br><br>
            
            <label for="message">Message (Optional):</label><br>
            <textarea id="message" name="message" rows="4" cols="50"></textarea><br><br>
            
            <button type="submit" class="btn btn-primary">Submit Booking</button>
        </form>
    </div>
</div>
