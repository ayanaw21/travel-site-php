<?php
class Hotel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllHotels() {
        $this->db->query('SELECT * FROM hotels ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getHotelById($id) {
        $this->db->query('SELECT * FROM hotels WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getHotelTypes() {
        $this->db->query('SELECT DISTINCT type FROM hotels ORDER BY type');
        return $this->db->resultSet();
    }

    public function getHotelsByType($type) {
        $this->db->query('SELECT * FROM hotels WHERE type = :type ORDER BY created_at DESC');
        $this->db->bind(':type', $type);
        return $this->db->resultSet();
    }

    public function getHotelsByPriceRange($min, $max) {
        $this->db->query('SELECT * FROM hotels WHERE price_per_night BETWEEN :min AND :max ORDER BY price_per_night ASC');
        $this->db->bind(':min', $min);
        $this->db->bind(':max', $max);
        return $this->db->resultSet();
    }

    public function bookHotel($data) {
        $this->db->query('INSERT INTO hotel_bookings (hotel_id, user_id, room_type, check_in, check_out, guests) VALUES (:hotel_id, :user_id, :room_type, :check_in, :check_out, :guests)');
        
        // Bind values
        $this->db->bind(':hotel_id', $data['hotel_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':room_type', $data['room_type']);
        $this->db->bind(':check_in', $data['check_in']);
        $this->db->bind(':check_out', $data['check_out']);
        $this->db->bind(':guests', $data['guests']);

        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function isRoomAvailable($hotel_id, $room_type, $check_in, $check_out) {
        $this->db->query('SELECT * FROM hotel_bookings WHERE hotel_id = :hotel_id AND room_type = :room_type AND 
            ((check_in BETWEEN :check_in AND :check_out) OR 
            (check_out BETWEEN :check_in AND :check_out))');
        
        $this->db->bind(':hotel_id', $hotel_id);
        $this->db->bind(':room_type', $room_type);
        $this->db->bind(':check_in', $check_in);
        $this->db->bind(':check_out', $check_out);

        $this->db->execute();
        return $this->db->rowCount() == 0;
    }

    public function getFeaturedHotels($limit = 6) {
        $sql = "SELECT h.*, d.name as destination_name 
                FROM hotels h
                JOIN destinations d ON h.destination_id = d.id
                WHERE h.featured = 1
                ORDER BY RAND() LIMIT :limit";
        $this->db->query($sql);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getHotelsByDestination($destination_id) {
        $sql = "SELECT h.*, d.name as destination_name 
                FROM hotels h
                JOIN destinations d ON h.destination_id = d.id
                WHERE h.destination_id = :destination_id";
        $this->db->query($sql);
        $this->db->bind(':destination_id', $destination_id);
        return $this->db->resultSet();
    }

    public function getHotelWithDetails($id) {
        $sql = "SELECT h.*, d.name as destination_name, d.description as destination_description
                FROM hotels h
                JOIN destinations d ON h.destination_id = d.id
                WHERE h.id = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function searchHotels($query) {
        $sql = "SELECT h.*, d.name as destination_name 
                FROM hotels h
                JOIN destinations d ON h.destination_id = d.id
                WHERE h.name LIKE :query 
                OR h.description LIKE :query 
                OR d.name LIKE :query";
        $this->db->query($sql);
        $this->db->bind(':query', '%' . $query . '%');
        return $this->db->resultSet();
    }

    public function getHotelsByRating($rating) {
        $sql = "SELECT h.*, d.name as destination_name 
                FROM hotels h
                JOIN destinations d ON h.destination_id = d.id
                WHERE h.rating >= :rating";
        $this->db->query($sql);
        $this->db->bind(':rating', $rating);
        return $this->db->resultSet();
    }

    public function getHotelsByAmenities($amenities) {
        $sql = "SELECT h.*, d.name as destination_name 
                FROM hotels h
                JOIN destinations d ON h.destination_id = d.id
                WHERE h.amenities LIKE :amenities";
        $this->db->query($sql);
        $this->db->bind(':amenities', '%' . $amenities . '%');
        return $this->db->resultSet();
    }

    public function getRelatedHotels($hotel_id, $destination_id, $limit = 3) {
        $sql = "SELECT h.*, d.name as destination_name 
                FROM hotels h
                JOIN destinations d ON h.destination_id = d.id
                WHERE h.destination_id = :destination_id 
                AND h.id != :hotel_id
                LIMIT :limit";
        $this->db->query($sql);
        $this->db->bind(':destination_id', $destination_id);
        $this->db->bind(':hotel_id', $hotel_id);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getHotelReviews($hotel_id) {
        $sql = "SELECT r.*, u.first_name, u.last_name, u.avatar
                FROM reviews r
                JOIN users u ON r.user_id = u.id
                WHERE r.hotel_id = :hotel_id
                ORDER BY r.created_at DESC";
        $this->db->query($sql);
        $this->db->bind(':hotel_id', $hotel_id);
        return $this->db->resultSet();
    }

    public function addReview($data) {
        $sql = "INSERT INTO reviews (hotel_id, user_id, rating, comment, created_at)
                VALUES (:hotel_id, :user_id, :rating, :comment, NOW())";
        $this->db->query($sql);
        $this->db->bind(':hotel_id', $data['hotel_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':comment', $data['comment']);
        return $this->db->execute();
    }
} 