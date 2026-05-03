create view lecturer_departments_view as
SELECT 
    l.lecturer_id,
    l.name,
    l.email,
    d.dept_name
FROM lecturers l
JOIN departments d 
    ON l.dept_id = d.dept_id;



