
INSERT INTO departments (dept_name)
VALUES
    ('Business Management'),
    ('Quantity Surveying'),
    ('Education Technology');
    ('Information Technology');


INSERT INTO lecturers (name, email, dept_id)
VALUES
    ('Dr. Jayasuriya', 'jayasuriya@uovt.ac.lk', 1),  
    ('Mr. Bandara', 'bandara@uovt.ac.lk', 3),        
    ('Dr. Gunawardena', 'gunawardena@uovt.ac.lk', 4), 
    ('Ms. Herath', 'herath@uovt.ac.lk', 5); 


INSERT INTO courses (course_name, lecturer_id)
VALUES
    ('Web Application Development', 3),
    ('Project Management', 4),          
    ('Construction Technology', 5),    
    ('Educational Psychology', 6),     
    ('Advanced Database Systems', 1);   


INSERT INTO students (first_name, last_name, contact_email)
VALUES
    ('Kasun', 'Kalhara', 'kasun@uovt.ac.lk'),
    ('Sachini', 'Weerasinghe', 'sachini@uovt.ac.lk'),
    ('Ruwan', 'Kumara', 'ruwan@uovt.ac.lk'),
    ('Dinithi', 'Alwis', 'dinithi@uovt.ac.lk'),
    ('Chamara', 'Silva', 'chamara@uovt.ac.lk');


--  dummy hash (password : admin123) 
INSERT INTO system_users (email, password_hash, role)
VALUES
    ('perera@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a','User'),
    ('silva@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a','User'),
    ('nimal@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a','User'),
    ('ayesha@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a','User'),
    ('admin@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a', 'Admin');