-- 1. Feature: Enrollments Procedure 1 & Transaction 1
DELIMITER //

CREATE PROCEDURE EnrollStudent(
    IN p_student_id INT,
    IN p_course_id INT
)
BEGIN
    DECLARE exit handler for sqlexception
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    INSERT INTO enrollments (student_id, course_id)
    VALUES (p_student_id, p_course_id);

    UPDATE courses
    SET total_enrolled = total_enrolled + 1
    WHERE course_id = p_course_id;

    COMMIT;
END //

DELIMITER ;

-- 2. Feature: Trigger 1 (Maintain Course Totals)
DELIMITER //
CREATE TRIGGER After_Enrollment_Delete
AFTER DELETE ON enrollments
FOR EACH ROW
BEGIN
    UPDATE courses SET total_enrolled = total_enrolled - 1 WHERE course_id = OLD.course_id;
END //
DELIMITER ;


-- 3. Feature: Views ENROLLMENT REPORT
CREATE VIEW ViewEnrollments AS
SELECT 
    e.enrollment_id,
    e.enrollment_date,
    s.student_id,
    s.first_name,
    s.last_name,
    c.course_id,
    c.course_name
FROM enrollments AS e
INNER JOIN students AS s 
    ON e.student_id = s.student_id
INNER JOIN courses AS c 
    ON e.course_id = c.course_id
ORDER BY e.enrollment_date DESC;