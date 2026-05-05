create view lecturer_departments_view as
SELECT 
    l.lecturer_id,
    l.name,
    l.email,
    d.dept_name
FROM lecturers l
JOIN departments d 
    ON l.dept_id = d.dept_id;

DELIMITER $$

CREATE PROCEDURE delete_lecturer(IN p_lecturer_id INT)
BEGIN
    DELETE FROM lecturers 
    WHERE lecturer_id = p_lecturer_id;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE update_lecturer(
    IN p_lecturer_id INT,
    IN p_name VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_dept_id INT
)
BEGIN
    UPDATE lecturers 
    SET 
        name = p_name,
        email = p_email,
        dept_id = p_dept_id
    WHERE lecturer_id = p_lecturer_id;
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE insert_lecturer(
    IN p_name VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_dept_id INT
)
BEGIN
    INSERT INTO lecturers (name, email, dept_id)
    VALUES (p_name, p_email, p_dept_id);

    SELECT LAST_INSERT_ID() AS lecturer_id, 'SUCCESS' AS status;
END$$

DELIMITER ;