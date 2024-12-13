<?php
require_once 'RestaurantDatabase.php';

class RestaurantPortal {
    private $db;

    public function __construct() {
        $this->db = RestaurantDatabase::getInstance();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'home';
        
        switch ($action) {
            case 'addReservation':
                include 'addReservation.php';
                break;
            case 'viewReservations':
                include 'viewReservations.php';
                break;
            default:
                include 'home.php';
        }
    }

    private function home() {
        include 'home.php';
    }

    private function addReservation() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerName = $_POST['customer_name'];
            $contactInfo = $_POST['contact_info'];
            $reservationTime = $_POST['reservation_time'];
            $numberOfGuests = $_POST['number_of_guests'];
            $specialRequests = $_POST['special_requests'];

            // Add reservation to the database
            $this->db->addReservation($customerName, $reservationTime, $numberOfGuests, $specialRequests);
            header("Location: index.php?action=viewReservations&message=Reservation+Added");
            exit;
        } else {
            include 'addReservation.php';
        }
    }

    private function viewReservations() {
        $reservations = $this->db->getAllReservations();
        include 'viewReservations.php';
    }
}

$portal = new RestaurantPortal();
$portal->handleRequest();

$portal = new RestaurantPortal();
$portal->handleRequest();
?>