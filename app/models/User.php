<?php
class User extends Model {
    protected $table = 'users';

    // Register user
    public function register($data) {
        // Remove confirm_password from data
        unset($data['confirm_password']);
        unset($data['first_name_err']);
        unset($data['last_name_err']);
        unset($data['email_err']);
        unset($data['password_err']);
        unset($data['confirm_password_err']);
        
        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Create user
        if($this->create($data)) {
            return true;
        }
        return false;
    }

    // Login user
    public function login($email, $password) {
        $user = $this->findOneBy('email', $email);

        if($user) {
            if(password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }

    // Find user by email
    public function findByEmail($email) {
        return $this->findOneBy('email', $email);
    }

    // Update user profile
    public function updateProfile($id, $data) {
        // If password is being updated, hash it
        if(isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        return $this->update($id, $data);
    }

    // Get user with role
    public function getUserWithRole($id) {
        $this->db->query("SELECT * FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Get all users
    public function getAllUsers() {
        return $this->getAll();
    }

    // Search users
    public function searchUsers($query) {
        $fields = ['first_name', 'last_name', 'email'];
        return $this->search($query, $fields);
    }

    // Get users with pagination
    public function getUsersPaginated($page = 1, $per_page = 10) {
        return $this->getPaginated($page, $per_page);
    }

    // Count total users
    public function getTotalUsers() {
        return $this->count();
    }
} 