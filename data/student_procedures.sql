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

DELIMITER ;
