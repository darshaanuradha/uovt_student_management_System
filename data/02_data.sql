
USE uovt_sms;

INSERT INTO departments (dept_name)
VALUES
    ('Business Management'),
    ('Quantity Surveying'),
    ('Education Technology'),
    ('Information Technology'),
    ('Software Engineering'),
    ('Network Engineering'),
    ('Cyber Security'),
    ('Data Science'),
    ('Artificial Intelligence'),
    ('Project Management');

INSERT INTO lecturers (name, email, dept_id)
VALUES
    ('Dr. Perera', 'perera@uovt.ac.lk', 5),
    ('Mr. Fernando', 'fernando@uovt.ac.lk', 6),
    ('Ms. Silva', 'silva@uovt.ac.lk', 7),
    ('Dr. Wickramasinghe', 'wickrama@uovt.ac.lk', 8),
    ('Mr. De Silva', 'desilva@uovt.ac.lk', 9),
    ('Ms. Karunaratne', 'karuna@uovt.ac.lk', 10),
    ('Dr. Rajapaksha', 'rajapaksha@uovt.ac.lk', 1),
    ('Mr. Senanayake', 'senanayake@uovt.ac.lk', 2),
    ('Ms. Dias', 'dias@uovt.ac.lk', 3),
    ('Dr. Abeysinghe', 'abey@uovt.ac.lk', 4),
    ('Mr. Madushanka', 'madushanka@uovt.ac.lk', 5);


INSERT INTO courses (course_name, lecturer_id)
VALUES
    ('Web Application Development', 3),
    ('Project Management', 4),
    ('Construction Technology', 2),
    ('Educational Psychology', 1),
    ('Advanced Database Systems', 1),
    ('Cyber Security Fundamentals', 6),
    ('Artificial Intelligence Concepts', 7),
    ('Software Engineering Principles', 5);


INSERT INTO students (first_name, last_name, contact_email)
VALUES
('Nimal','Perera','nimal1@uovt.ac.lk'),
('Saman','Fernando','saman1@uovt.ac.lk'),
('Kavindi','Silva','kavindi1@uovt.ac.lk'),
('Tharindu','Perera','tharindu1@uovt.ac.lk'),
('Ishara','Gunawardena','ishara1@uovt.ac.lk'),
('Malsha','Senanayake','malsha1@uovt.ac.lk'),
('Dilan','Rajapaksha','dilan1@uovt.ac.lk'),
('Piumi','Karunaratne','piumi1@uovt.ac.lk'),
('Sanduni','Dias','sanduni1@uovt.ac.lk'),
('Ravindu','Perera','ravindu1@uovt.ac.lk'),

('Ashen','Fernando','ashen1@uovt.ac.lk'),
('Nisala','Silva','nisala1@uovt.ac.lk'),
('Vihangi','Perera','vihangi1@uovt.ac.lk'),
('Supun','Gunasekara','supun1@uovt.ac.lk'),
('Madushi','Perera','madushi1@uovt.ac.lk'),
('Gayan','Fernando','gayan1@uovt.ac.lk'),
('Thilini','Silva','thilini1@uovt.ac.lk'),
('Chamod','Perera','chamod1@uovt.ac.lk'),
('Hasini','Fernando','hasini1@uovt.ac.lk'),
('Udara','Silva','udara1@uovt.ac.lk'),

('Kasuni','Perera','kasuni1@uovt.ac.lk'),
('Chathura','Fernando','chathura1@uovt.ac.lk'),
('Rashmi','Silva','rashmi1@uovt.ac.lk'),
('Dinuka','Perera','dinuka1@uovt.ac.lk'),
('Lakshmi','Fernando','lakshmi1@uovt.ac.lk'),
('Sajith','Silva','sajith1@uovt.ac.lk'),
('Nadeesha','Perera','nadeesha1@uovt.ac.lk'),
('Ramesh','Fernando','ramesh1@uovt.ac.lk'),
('Iresha','Silva','iresha1@uovt.ac.lk'),
('Janith','Perera','janith1@uovt.ac.lk'),

('Sandaru','Fernando','sandaru1@uovt.ac.lk'),
('Dinesh','Silva','dinesh1@uovt.ac.lk'),
('Harini','Perera','harini1@uovt.ac.lk'),
('Suresh','Fernando','suresh1@uovt.ac.lk'),
('Imesha','Silva','imesha1@uovt.ac.lk'),
('Rukshan','Perera','rukshan1@uovt.ac.lk'),
('Samanthi','Fernando','samanthi1@uovt.ac.lk'),
('Kelum','Silva','kelum1@uovt.ac.lk'),
('Shanika','Perera','shanika1@uovt.ac.lk'),
('Praveen','Fernando','praveen1@uovt.ac.lk'),

('Nirosha','Silva','nirosha1@uovt.ac.lk'),
('Dulanjan','Perera','dulanjan1@uovt.ac.lk'),
('Sanjeewa','Fernando','sanjeewa1@uovt.ac.lk'),
('Pabasara','Silva','pabasara1@uovt.ac.lk'),
('Ravishka','Perera','ravishka1@uovt.ac.lk'),
('Ashani','Fernando','ashani1@uovt.ac.lk'),
('Sithumina','Silva','sithumina1@uovt.ac.lk'),
('Dilhani','Perera','dilhani1@uovt.ac.lk'),
('Kavishka','Fernando','kavishka1@uovt.ac.lk'),
('Tharushi','Silva','tharushi1@uovt.ac.lk'),

('Rangana','Perera','rangana1@uovt.ac.lk'),
('Manoj','Fernando','manoj1@uovt.ac.lk'),
('Shashika','Silva','shashika1@uovt.ac.lk'),
('Gihan','Perera','gihan1@uovt.ac.lk'),
('Nipuni','Fernando','nipuni1@uovt.ac.lk'),
('Roshan','Silva','roshan1@uovt.ac.lk'),
('Duminda','Perera','duminda1@uovt.ac.lk'),
('Anjali','Fernando','anjali1@uovt.ac.lk'),
('Chinthaka','Silva','chinthaka1@uovt.ac.lk'),
('Sahan','Perera','sahan1@uovt.ac.lk'),

('Kanchana','Fernando','kanchana1@uovt.ac.lk'),
('Roshani','Silva','roshani1@uovt.ac.lk'),
('Vishwa','Perera','vishwa1@uovt.ac.lk'),
('Chamari','Fernando','chamari1@uovt.ac.lk'),
('Pasindu','Silva','pasindu1@uovt.ac.lk'),
('Tharanga','Perera','tharanga1@uovt.ac.lk'),
('Nayana','Fernando','nayana1@uovt.ac.lk'),
('Upeksha','Silva','upeksha1@uovt.ac.lk'),
('Janaka','Perera','janaka1@uovt.ac.lk'),
('Dilrukshi','Fernando','dilrukshi1@uovt.ac.lk'),

('Rukmini','Silva','rukmini1@uovt.ac.lk'),
('Shehan','Perera','shehan1@uovt.ac.lk'),
('Yasiru','Fernando','yasiru1@uovt.ac.lk'),
('Malini','Silva','malini1@uovt.ac.lk'),
('Isuru','Perera','isuru1@uovt.ac.lk');


--  dummy hash (password : admin123) 
INSERT INTO system_users (email, password_hash, role)
VALUES
    ('perera@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a','User'),
    ('silva@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a','User'),
    ('nimal@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a','User'),
    ('ayesha@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a','User'),
    ('admin@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a', 'Admin');