<?php
class Contact {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addMessage($name, $email, $message, $subject = '') {
        $this->db->query('INSERT INTO contacts (name, email, subject, message) VALUES (:name, :email, :subject, :message)');
        
        $this->db->bind(':name', $name);
        $this->db->bind(':email', $email);
        $this->db->bind(':subject', $subject);
        $this->db->bind(':message', $message);

        return $this->db->execute();
    }
}