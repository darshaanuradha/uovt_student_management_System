CREATE VIEW view_departments AS
SELECT dept_id, dept_name
FROM departments;

DELIMITER $$

CREATE PROCEDURE AddDepartment(IN p_name VARCHAR(255))
BEGIN
    IF p_name IS NULL OR TRIM(p_name) = '' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Department name cannot be empty';
    END IF;

    INSERT INTO departments (dept_name)
    VALUES (TRIM(p_name));
END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE UpdateDepartment(
    IN p_id INT,
    IN p_name VARCHAR(255)
)
BEGIN
    IF p_id IS NULL OR p_id <= 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid department ID';
    END IF;

    IF p_name IS NULL OR TRIM(p_name) = '' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Department name cannot be empty';
    END IF;

    UPDATE departments
    SET dept_name = TRIM(p_name)
    WHERE dept_id = p_id;

    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Department not found or no change';
    END IF;

END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE DeleteDepartment(IN p_id INT)
BEGIN
    IF p_id IS NULL OR p_id <= 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid department ID';
    END IF;

    DELETE FROM departments
    WHERE dept_id = p_id;

    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Department not found';
    END IF;

END $$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE GetDepartmentById(IN p_id INT)
BEGIN
    SELECT dept_id, dept_name
    FROM departments
    WHERE dept_id = p_id;
END $$

DELIMITER ;