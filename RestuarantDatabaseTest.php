<?php
class RestaurantDatabase {
    //database connection details matching mySQL info
    private static $instance = null;
    private $host = "localhost";
    private $port = "3306";
    private $database = "resturant_reservations";
    private $user = "root";
    private $password = "";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    public static function getInstance(): RestaurantDatabase{
        if (self::$instance === null) {
            self::$instance == new RestaurantDatabase();
        }
        return self::$instance;
    }

    private function connect(): void {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        echo "Congrats - You successfully connected to the database";
    }

    public function getConnection(): mysqli{
        return $this->$connection;
    }

    //function to add reservations, taking customer name, reservation time, number of guests and special requests as parameters
    public function addReservation($customerName, $reservationTime, $numberOfGuests, $specialRequests) {
        $customerId = $this->addCustomer($customerName, "unknown"); // Add with dummy contact info if not provided
        $stmt = $this->connection->prepare(
            "INSERT INTO Reservations (customerId, reservationTime, numberOfGuests, specialRequests) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("isis", $customerId, $reservationTime, $numberOfGuests, $specialRequests);
        $stmt->execute();
        $stmt->close();
    }

    public function getAllReservations() {
        $result = $this->connection->query("SELECT * FROM reservations");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //method to add customers to resturant database, taking customer name and contact info as parameters
    public function addCustomer($customerName, $contactInfo) {
        $stmt = $this->connection->prepare("SELECT customerId FROM Customers WHERE customerName = ? AND contactInfo = ?");
        $stmt->bind_param("ss", $customerName, $contactInfo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['customerId'];
        } else {
            $stmt = $this->connection->prepare("INSERT INTO Customers (customerName, contactInfo) VALUES (?, ?)");
            $stmt->bind_param("ss", $customerName, $contactInfo);
            $stmt->execute();
            return $this->connection->insert_id;
        }
    }

    //fundtion to get customer preferences by customer ID as a parameter
    public function getCustomerPreferences($customerId) {
        $stmt = $this->connection->prepare("SELECT * FROM DiningPreferences WHERE customerId = ?");
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>