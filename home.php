<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Portal</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: #fff;
            text-align: center;
            background: url('https://hips.hearstapps.com/townandcountry/assets/17/01/lebernardin-daniel-krieger.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        h1 {
            font-size: 3rem;
            margin-top: 2rem;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        a {
            display: inline-block;
            margin: 1rem;
            padding: 1rem 2rem;
            font-size: 1.5rem;
            color: #007bff;
            background: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s, transform 0.2s;
        }

        a:hover {
            background: rgba(255, 255, 255, 1);
            transform: scale(1.05);
        }

        footer {
            margin-top: 3rem;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.6);
            color: #ccc;
            font-size: 0.9rem;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <h1>Welcome to the Restaurant Manager Portal</h1>
    <a href="index.php?action=addReservation">Add a Reservation</a>
    <a href="index.php?action=viewReservations">View Current Reservations</a>

    <footer>
        &copy; 2024 Restaurant Manager Portal. All rights reserved.
    </footer>
</body>
</html>
