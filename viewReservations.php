<?php
require_once 'RestaurantDatabase.php';

// Fetch reservations from the database
try {
    $db = RestaurantDatabase::getInstance();
    $reservations = $db->getAllReservations();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<html>
<head>
    <title>View Reservations</title>
</head>
<body>
    <h1>All Reservations</h1>
    <?php if (!empty($reservations)): ?>
    <table border="1">
        <tr>
            <th>Reservation ID</th>
            <th>Customer Name</th>
            <th>Contact Info</th>
            <th>Reservation Time</th>
            <th>Number of Guests</th>
            <th>Special Requests</th>
        </tr>
        <?php foreach ($reservations as $reservation): ?>
        <tr>
            <td><?= htmlspecialchars($reservation['reservationId']) ?></td>
            <td><?= htmlspecialchars($reservation['customerName']) ?></td>
            <td><?= htmlspecialchars($reservation['contactInfo']) ?></td>
            <td><?= htmlspecialchars($reservation['reservationTime']) ?></td>
            <td><?= htmlspecialchars($reservation['numberOfGuests']) ?></td>
            <td><?= htmlspecialchars($reservation['specialRequests']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>No reservations found.</p>
    <?php endif; ?>
    <a href="index.php">Back to Home</a>
</body>
</html>