-- Update destinations table image paths
UPDATE destinations SET image = 'lalibela.jpg' WHERE name = 'Lalibela Wonders';
UPDATE destinations SET image = 'Simien-Mountains-Ethiopia.jpg' WHERE name = 'Simien Mountains';
UPDATE destinations SET image = 'dalole.webp' WHERE name = 'Danakil Depression';

-- Update destination gallery image paths
UPDATE destination_gallery SET image_url = 'lalibela d1.jpg' WHERE destination_id = 1 AND caption LIKE '%Bete Giyorgis%';
UPDATE destination_gallery SET image_url = 'lalibela d3.jpg' WHERE destination_id = 1 AND caption LIKE '%Interior%';
UPDATE destination_gallery SET image_url = 's1.jpg' WHERE destination_id = 2 AND caption LIKE '%landscape%';
UPDATE destination_gallery SET image_url = 's1.jpg' WHERE destination_id = 2 AND caption LIKE '%Gelada%';
UPDATE destination_gallery SET image_url = 'dalole.webp' WHERE destination_id = 3 AND caption LIKE '%sulfur%';
UPDATE destination_gallery SET image_url = 'dalole.webp' WHERE destination_id = 3 AND caption LIKE '%lava%';

-- Update attractions image paths
UPDATE attractions SET image_url = 'lalibela d1.jpg' WHERE name = 'Bete Giyorgis';
UPDATE attractions SET image_url = 'lalibela d3.jpg' WHERE name = 'Lalibela Market';
UPDATE attractions SET image_url = 's1.jpg' WHERE name = 'Gelada Monkeys';
UPDATE attractions SET image_url = 'rasdasen.jpg' WHERE name = 'Ras Dashen';
UPDATE attractions SET image_url = 'dalole.webp' WHERE name = 'Erta Ale Volcano';
UPDATE attractions SET image_url = 'dalole.webp' WHERE name = 'Dallol Sulfur Springs';

-- Update hotels image paths
UPDATE hotels SET image = 'hotels1.jpg' WHERE name = 'Lalibela Lodge';
UPDATE hotels SET image = 'hotels2.jpg' WHERE name = 'Simien Lodge';
UPDATE hotels SET image = 'hotels3.jpg' WHERE name = 'Gheralta Lodge';

-- Update cars image paths
UPDATE cars SET image = 'car1.jpg' WHERE model = 'Toyota Land Cruiser';
UPDATE cars SET image = 'car2.jpg' WHERE model = 'Hiace Minibus';
UPDATE cars SET image = 'car3.jpg' WHERE model = 'Toyota RAV4';

-- Update packages image paths
UPDATE packages SET image = 'lalibela.jpg' WHERE name = 'Historical Ethiopia';
UPDATE packages SET image = 'Simien-Mountains-Ethiopia.jpg' WHERE name = 'Mountain Trekking';
UPDATE packages SET image = 'dalole.webp' WHERE name = 'Danakil Expedition'; 


select * from contacts;

select * from users;
select * from bookings;