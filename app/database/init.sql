-- Create users table if it doesn't exist
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    role TEXT DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create packages table if it doesn't exist
CREATE TABLE IF NOT EXISTS packages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    duration_days INTEGER NOT NULL,
    type TEXT NOT NULL,
    destination_id INTEGER NOT NULL,
    image TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (destination_id) REFERENCES destinations(id)
);

-- Create destinations table if it doesn't exist
CREATE TABLE IF NOT EXISTS destinations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    description TEXT NOT NULL,
    image TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample destinations
INSERT INTO destinations (name, description, image) VALUES
('Lalibela', 'Home to the famous rock-hewn churches, a UNESCO World Heritage site.', 'img/destinations/lalibela.jpg'),
('Simien Mountains', 'A stunning mountain range with unique wildlife and breathtaking views.', 'img/destinations/simien.jpg'),
('Danakil Depression', 'One of the hottest places on Earth with unique geological features.', 'img/destinations/danakil.jpg'),
('Axum', 'Ancient city with historical monuments and religious significance.', 'img/destinations/axum.jpg'),
('Bale Mountains', 'Home to diverse wildlife and beautiful landscapes.', 'img/destinations/bale.jpg'),
('Gondar', 'Known as the "Camelot of Africa" with its medieval castles.', 'img/destinations/gondar.jpg'),
('Omo Valley', 'Rich in cultural diversity and traditional customs.', 'img/destinations/omo.jpg'),
('Harar', 'Ancient walled city with unique Islamic heritage.', 'img/destinations/harar.jpg');

-- Insert sample packages
INSERT INTO packages (title, description, price, duration_days, type, destination_id, image) VALUES
('Lalibela Rock-Hewn Churches Tour', 'Experience the ancient rock-hewn churches of Lalibela, a UNESCO World Heritage site. This tour includes visits to all 11 churches, local cultural experiences, and traditional Ethiopian cuisine.', 899.99, 3, 'Cultural', 1, 'img/packages/lalibela.jpg'),
('Simien Mountains Trek', 'Trek through the stunning Simien Mountains National Park, home to rare wildlife including the Gelada baboon and Ethiopian wolf. Includes guided hiking, camping equipment, and park permits.', 1299.99, 5, 'Adventure', 2, 'img/packages/simien.jpg'),
('Danakil Depression Expedition', 'Visit one of the hottest places on Earth. Experience the otherworldly landscapes, active volcanoes, and salt lakes. Includes 4x4 transportation, camping gear, and local guides.', 1499.99, 4, 'Adventure', 3, 'img/packages/danakil.jpg'),
('Axum Historical Tour', 'Explore the ancient city of Axum, home to the famous obelisks and the Church of St. Mary of Zion. Learn about Ethiopia''s rich history and the legend of the Ark of the Covenant.', 799.99, 2, 'Cultural', 4, 'img/packages/axum.jpg'),
('Bale Mountains Wildlife Safari', 'Discover the diverse wildlife of Bale Mountains National Park. Spot Ethiopian wolves, mountain nyala, and various bird species. Includes guided tours and accommodation.', 1099.99, 4, 'Wildlife', 5, 'img/packages/bale.jpg'),
('Gondar Castle Tour', 'Visit the Royal Enclosure in Gondar, known as the "Camelot of Africa". Explore the medieval castles and churches, and learn about Ethiopia''s imperial history.', 699.99, 2, 'Cultural', 6, 'img/packages/gondar.jpg'),
('Omo Valley Cultural Experience', 'Immerse yourself in the diverse cultures of the Omo Valley. Meet various ethnic groups, witness traditional ceremonies, and learn about their unique customs.', 1599.99, 6, 'Cultural', 7, 'img/packages/omo.jpg'),
('Harar City Tour', 'Explore the ancient walled city of Harar, known for its 99 mosques and unique hyena feeding tradition. Experience the vibrant markets and rich Islamic heritage.', 899.99, 3, 'Cultural', 8, 'img/packages/harar.jpg');

select * from packages;