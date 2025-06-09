<?php
require_once '../app/config/config.php';
require_once '../app/core/Database.php';

// Create database connection
$db = new Database();

// Sample users data
$users = [
    [
        'first_name' => 'Admin',
        'last_name' => 'User',
        'email' => 'admin@travelhabesha.com',
        'password' => 'admin123' // This will be hashed
    ],
    [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@travelhabesha.com',
        'password' => 'test123' // This will be hashed
    ]
];

// Insert users
foreach ($users as $user) {
    $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (first_name, last_name, email, password, created_at) 
            VALUES (:first_name, :last_name, :email, :password, datetime('now'))";
    
    $db->query($sql);
    $db->bind(':first_name', $user['first_name']);
    $db->bind(':last_name', $user['last_name']);
    $db->bind(':email', $user['email']);
    $db->bind(':password', $hashedPassword);
    
    if($db->execute()) {
        echo "User {$user['email']} created successfully with password: {$user['password']}\n";
    } else {
        echo "Error creating user {$user['email']}\n";
    }
}

echo "\nLogin credentials:\n";
echo "1. Admin User:\n";
echo "   Email: admin@travelhabesha.com\n";
echo "   Password: admin123\n\n";
echo "2. Test User:\n";
echo "   Email: test@travelhabesha.com\n";
echo "   Password: test123\n"; 