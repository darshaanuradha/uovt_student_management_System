USE uovt_sms;

DELIMITER $$

-- ============================================================
-- sp_get_courses
-- Fetches all courses with joined lecturer name
-- ============================================================
CREATE PROCEDURE sp_get_courses()
BEGIN
    SELECT
        c.course_id,
        c.course_name,
        c.total_enrolled,
        l.lecturer_id,
        l.name AS lecturer_name
    FROM courses c
    LEFT JOIN lecturers l ON c.lecturer_id = l.lecturer_id
    ORDER BY c.course_id ASC;
END$$

-- ============================================================
-- sp_get_course_by_id
-- Fetches a single course for editing
-- ============================================================
CREATE PROCEDURE sp_get_course_by_id(IN p_course_id INT)
BEGIN
    SELECT
        c.course_id,
        c.course_name,
        c.lecturer_id,
        c.total_enrolled
    FROM courses c
    WHERE c.course_id = p_course_id;
END$$

-- ============================================================
-- sp_insert_course
-- Inserts a new course record
-- ============================================================
CREATE PROCEDURE sp_insert_course(
    IN p_course_name  VARCHAR(150),
    IN p_lecturer_id  INT
)
BEGIN
    INSERT INTO courses (course_name, lecturer_id)
    VALUES (p_course_name, p_lecturer_id);
END$$

-- ============================================================
-- sp_update_course
-- Updates an existing course record
-- ============================================================
CREATE PROCEDURE sp_update_course(
    IN p_course_id    INT,
    IN p_course_name  VARCHAR(150),
    IN p_lecturer_id  INT
)
BEGIN
    UPDATE courses
    SET
        course_name  = p_course_name,
        lecturer_id  = p_lecturer_id
    WHERE course_id = p_course_id;
END$$

-- ============================================================
-- sp_delete_course
-- Deletes a course record
-- ============================================================
CREATE PROCEDURE sp_delete_course(IN p_course_id INT)
BEGIN
    DELETE FROM courses WHERE course_id = p_course_id;
END$$

-- ============================================================
-- sp_get_all_lecturers
-- Used to populate the lecturer dropdown in the form
-- ============================================================
CREATE PROCEDURE sp_get_all_lecturers()
BEGIN
    SELECT lecturer_id, name FROM lecturers ORDER BY name ASC;
END$$

DELIMITER ;
