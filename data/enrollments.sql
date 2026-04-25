-- 1. Enrollments Procedure & Transaction
CREATE PROCEDURE EnrollStudent(IN p_student_id VARCHAR(20), IN p_course_id VARCHAR(10))
BEGIN
    DECLARE exit handler for sqlexception
    BEGIN
        ROLLBACK;
    END;
    START TRANSACTION;
    INSERT INTO enrollments (student_id, course_id) VALUES (p_student_id, p_course_id);
    UPDATE courses SET total_enrolled = total_enrolled + 1 WHERE course_id = p_course_id;
    COMMIT;
END 


