<?php
class Bookings extends Controller {
    private $bookingModel;
    private $userModel;

    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->bookingModel = $this->model('Booking');
        $this->userModel = $this->model('User');
    }

    public function index() {
        $bookings = $this->bookingModel->getUserBookings($_SESSION['user_id']);
        $data = [
            'bookings' => $bookings
        ];
        $this->view('bookings/index', $data);
    }

    public function show($id) {
        $booking = $this->bookingModel->getBookingById($id);
        
        // Check if booking exists and belongs to user
        if (!$booking || $booking->user_id != $_SESSION['user_id']) {
            redirect('bookings');
        }

        $data = [
            'booking' => $booking
        ];
        $this->view('bookings/show', $data);
    }

    public function create() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        $data = [
            'user_id' => $_SESSION['user_id'],
            'booking_type' => trim($_POST['booking_type']),
            'item_id' => trim($_POST['item_id']),
            'start_date' => trim($_POST['start_date']),
            'end_date' => trim($_POST['end_date']),
            'total_price' => calculateTotalPrice(), // Implement this function
            'start_date_err' => '',
            'end_date_err' => ''
        ];

        // Validate data
        if (empty($data['start_date'])) {
            $data['start_date_err'] = 'Please enter start date';
        }
        // Add other validations...

        if (empty($data['start_date_err']) && empty($data['end_date_err'])) {
            if ($this->bookingModel->createBooking($data)) {
                flash('booking_message', 'Booking Created');
                redirect('bookings');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->view('bookings/create', $data);
        }
    } else {
        // Load form with default values
        $data = [
            'booking_type' => '',
            'item_id' => '',
            'start_date' => '',
            'end_date' => '',
            'total_price' => ''
        ];
        $this->view('bookings/create', $data);
    }
}

    public function cancel($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $booking = $this->bookingModel->getBookingById($id);
            
            // Check if booking exists and belongs to user
            if (!$booking || $booking->user_id != $_SESSION['user_id']) {
                redirect('bookings');
            }

            if ($this->bookingModel->cancelBooking($id)) {
                flash('booking_message', 'Booking Cancelled');
                redirect('bookings');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('bookings');
        }
    }

    public function confirm($id) {
        // Only admin should be able to confirm
        if (!isAdmin()) {
            redirect('bookings');
        }
        if ($this->bookingModel->confirmBooking($id)) {
            flash('booking_confirmed', 'Booking confirmed successfully');
        } else {
            flash('booking_error', 'Unable to confirm booking', 'alert alert-danger');
        }
        redirect('bookings');
    }

    public function pending() {
        // Only admin should be able to view pending bookings
        if (!isAdmin()) {
            redirect('bookings');
        }
        $bookings = $this->bookingModel->getPendingBookings();
        $data = [
            'bookings' => $bookings
        ];
        $this->view('bookings/pending', $data);
    }
} 