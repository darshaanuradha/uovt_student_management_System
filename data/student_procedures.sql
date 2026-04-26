USE uovt_sms;
DELIMITER //

DROP PROCEDURE IF EXISTS sp_get_students // 
CREATE PROCEDURE sp_get_students() BEGIN
SELECT student_id,
    first_name,
    last_name,
    contact_email
FROM students
ORDER BY student_id DESC;
END // 

DROP PROCEDURE IF EXISTS sp_insert_student // 
CREATE PROCEDURE sp_insert_student(
    IN p_first_name VARCHAR(50),
    IN p_last_name VARCHAR(50),
    IN p_contact_email VARCHAR(100)
) BEGIN
INSERT INTO students (first_name, last_name, contact_email)
VALUES (p_first_name, p_last_name, p_contact_email);
END // 

DELIMITER ;
