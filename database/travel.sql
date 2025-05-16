-- 1. Drop existing tables (if needed)
DROP TABLE IF EXISTS users;

-- 2. Recreate tables
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    full_name TEXT,
    phone TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    is_admin INTEGER DEFAULT 0
);
-- select * from users
CREATE TABLE IF NOT EXISTS destinations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    description TEXT,
    location TEXT,
    image_path TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);
select * from destinations

CREATE TABLE IF NOT EXISTS packages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    destination_id INTEGER,
    title TEXT NOT NULL,
    description TEXT,
    duration_days INTEGER,
    price REAL,
    image_path TEXT,
    type TEXT,
    difficulty TEXT,
    min_age INTEGER,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (destination_id) REFERENCES destinations(id)
);

CREATE TABLE IF NOT EXISTS hotels (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    location TEXT,
    description TEXT,
    price_per_night REAL,
    rating INTEGER,
    image_path TEXT,
    amenities TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS rental_cars (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    model TEXT NOT NULL,
    type TEXT,
    price_per_day REAL,
    image_path TEXT,
    features TEXT,
    rating INTEGER,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS bookings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    package_id INTEGER,
    start_date TEXT,
    end_date TEXT,
    guests INTEGER,
    status TEXT DEFAULT 'pending',
    special_requests TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (package_id) REFERENCES packages(id)
);

CREATE TABLE IF NOT EXISTS contact_messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    message TEXT NOT NULL,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    status TEXT DEFAULT 'unread'
);

-- 3. Insert fresh data with realistic images
INSERT INTO users (username, email, password, full_name, phone, is_admin) VALUES
('admin', 'admin@travelhabesha.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User', '+251911223344', 1),
('john_doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John Doe', '+251911334455', 0),
('habesha_traveler', 'traveler@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Selamawit Kebede', '+251922556677', 0),
('mike_jones', 'mike@example.com', '$2y$10$Jz5XoN9Wq1UeYV7kQrZQ.eLbGv8wWj2fX1VlD3sMn5JxKtY0hH7dS', 'Mike Jones', '+251933445566', 1);

INSERT INTO destinations (name, description, location, image_path) VALUES
('Lalibela', 'Famous for its rock-hewn churches dating back to the 12th century, a UNESCO World Heritage Site.', 'Amhara Region', 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/df/Lalibela_Cross.jpg/800px-Lalibela_Cross.jpg'),
('Simien Mountains', 'Spectacular mountain range with unique wildlife including the Gelada baboon and Ethiopian wolf.', 'Northern Ethiopia', 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5b/Simien_Mountains_%2815%29.jpg/800px-Simien_Mountains_%2815%29.jpg'),
('Danakil Depression', 'One of the hottest places on earth with colorful sulfur springs and salt flats.', 'Afar Region', 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Dallol_-_panoramio.jpg/800px-Dallol_-_panoramio.jpg'),
('Axum', 'Ancient city with obelisks marking tombs and the legendary Ark of the Covenant.', 'Tigray Region', 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7d/Stelae_field_aksum.jpg/800px-Stelae_field_aksum.jpg'),
('Gondar', 'Known as the "Camelot of Africa" with its medieval castles and churches.', 'Amhara Region', 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5a/Fasil_Ghebbi.jpg/800px-Fasil_Ghebbi.jpg');

INSERT INTO packages (destination_id, title, description, duration_days, price, image_path, type, difficulty, min_age) VALUES
(1, 'Lalibela Pilgrimage Tour', 'Explore the 11 medieval monolithic cave churches of Lalibela.', 3, 450.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/Bete_Giyorgis_Lalibela_ETH_1978.jpg/800px-Bete_Giyorgis_Lalibela_ETH_1978.jpg', 'cultural', 'easy', 12),
(2, 'Simien Mountains Trek', '3-day trek through the "Roof of Africa" with stunning views.', 4, 650.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5b/Simien_Mountains_%2815%29.jpg/800px-Simien_Mountains_%2815%29.jpg', 'adventure', 'moderate', 16),
(3, 'Danakil Depression Expedition', 'Journey to one of the most inhospitable but beautiful places on Earth.', 2, 550.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Dallol_-_panoramio.jpg/800px-Dallol_-_panoramio.jpg', 'adventure', 'difficult', 18),
(4, 'Historical Axum Tour', 'Discover the ancient kingdom of Axum and its archaeological wonders.', 2, 350.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7d/Stelae_field_aksum.jpg/800px-Stelae_field_aksum.jpg', 'cultural', 'easy', 10),
(5, 'Gondar Castles Tour', 'Visit the 17th century castles of Emperor Fasilides and his successors.', 2, 400.00, 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5a/Fasil_Ghebbi.jpg/800px-Fasil_Ghebbi.jpg', 'cultural', 'easy', 10);

INSERT INTO hotels (name, location, description, price_per_night, rating, image_path, amenities) VALUES
('Lalibela Lodge', 'Lalibela', 'Eco-friendly lodge with stunning views of the mountains and churches.', 120.00, 4, 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'wifi,restaurant,pool'),
('Simien Lodge', 'Simien Mountains', 'Africa''s highest hotel at 3260m altitude with breathtaking views.', 150.00, 5, 'https://images.unsplash.com/photo-1582719471387-6d7658a973a3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'wifi,restaurant,bar,heating'),
('Gheralta Lodge', 'Tigray', 'Luxury lodge with panoramic views of the Gheralta mountains.', 180.00, 5, 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'wifi,spa,restaurant,pool'),
('Kuriftu Resort', 'Bishoftu', 'Lakeside resort with excellent facilities near Addis Ababa.', 200.00, 5, 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'wifi,spa,restaurant,pool,gym'),
('Haile Resort', 'Arba Minch', 'Beautiful resort overlooking Lake Abaya and Lake Chamo.', 160.00, 4, 'https://images.unsplash.com/photo-1568084680786-a84f91d1153c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'wifi,restaurant,pool');

INSERT INTO rental_cars (model, type, price_per_day, image_path, features, rating) VALUES
('Toyota Land Cruiser', '4x4 SUV', 120.00, 'https://images.unsplash.com/photo-1553440569-bcc63803a83d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'AC,4WD,7 seats', 5),
('Toyota Hilux', 'Pickup Truck', 90.00, 'https://images.unsplash.com/photo-1583121274602-3e2820c69888?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'AC,4WD,5 seats', 4),
('Mitsubishi Pajero', 'SUV', 80.00, 'https://images.unsplash.com/photo-1550354520-86a81c515d44?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'AC,4WD,5 seats', 4),
('Toyota Hiace', 'Minibus', 70.00, 'https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'AC,14 seats', 3),
('Hyundai Tucson', 'Compact SUV', 60.00, 'https://images.unsplash.com/photo-1631729371254-42c2892f0e6e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80', 'AC,5 seats', 4);

INSERT INTO bookings (user_id, package_id, start_date, end_date, guests, status, special_requests) VALUES
(2, 1, '2023-12-15', '2023-12-18', 2, 'confirmed', 'Vegetarian meals required'),
(3, 2, '2024-01-10', '2024-01-14', 4, 'pending', 'Need English speaking guide'),
(2, 3, '2024-02-05', '2024-02-07', 3, 'confirmed', '');

INSERT INTO contact_messages (name, email, message, status) VALUES
('Michael Johnson', 'michael@example.com', 'I would like to inquire about the best time to visit Lalibela.', 'replied'),
('Sarah Williams', 'sarah@example.com', 'Do you offer custom tour packages for large groups?', 'read'),
('David Smith', 'david@example.com', 'I need information about visa requirements for Ethiopia.', 'unread');