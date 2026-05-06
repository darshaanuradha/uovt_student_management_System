# UOVT Student Management System

Web-based academic management system built with Core PHP and MySQL for the IT304082 Database Implementation module. The application follows a simple 3-tier design and covers the main administrative workflows for departments, lecturers, students, courses, and enrollments.

## Overview

The system provides a single dashboard for managing core academic records:

- Authentication and session-based access control
- Department management
- Lecturer management
- Student management
- Course management
- Student enrollment and unenrollment
- Dashboard summaries and recent activity

The project is designed to demonstrate clean request handling, reusable database logic, and a structured separation between presentation, application, and data layers.

## Live Demo

The application is hosted at:

http://159.223.73.121/uovt_student_management_system/presentation/

## Features

- Role-based login for protected pages
- CRUD flows for departments, lecturers, students, and courses
- Course enrollment workflow with database-side integrity rules
- Stored procedures for common database actions
- Views for dashboard and reporting screens
- Prepared statements for safer database access
- Responsive UI built with Tailwind CSS

## Tech Stack

- Frontend: HTML, CSS, JavaScript, Tailwind CSS
- Backend: Core PHP
- Database: MySQL
- Local environment: WAMP

## Architecture

The codebase is organized into three layers:

- Presentation layer: pages in `presentation/` render the UI and forms
- Application layer: controllers in `application/` process requests and call the database
- Data layer: SQL scripts in `data/` define the schema, seed data, and database routines

## Project Structure

```text
uovt_student_management_system/
|-- application/
|   |-- auth.php
|   |-- courseController.php
|   |-- db.php
|   |-- departmentsController.php
|   |-- enrollmentsController.php
|   |-- lecturerController.php
|   `-- studentcontroller.php
|-- data/
|   |-- 01_schema.sql
|   |-- 02_data.sql
|   |-- 03_enrollments.sql
|   |-- 04_courses.sql
|   |-- 05_students.sql
|   |-- 06_departments.sql
|   `-- 07_lecturers.sql
|-- presentation/
|   |-- index.php
|   |-- layouts/
|   |   `-- main.php
|   |-- pages/
|   |   |-- add_department.php
|   |   |-- add_lecturer.php
|   |   |-- course_add_form.php
|   |   |-- courses.php
|   |   |-- dashboard.php
|   |   |-- departments.php
|   |   |-- edit_department.php
|   |   |-- edit_lecturer.php
|   |   |-- enroll_student_form.php
|   |   |-- enrollments.php
|   |   |-- lecturers.php
|   |   |-- login.php
|   |   |-- student_add_form.php
|   |   `-- students.PHP
|   `-- partials/
|       |-- header.php
|       |-- sidebar.php
|       `-- footer.php
|-- README.md
|-- TeamGitWorkflowGuide.md
`-- issue.md
```

## Setup

### 1. Place the project in the web root

Copy the project folder into your WAMP web directory:

```text
C:\wamp64\www\
```

### 2. Create the database

Open phpMyAdmin in your browser:

```text
http://localhost/phpmyadmin
```

Create a new database named `uovt_sms`.

### 3. Import the SQL scripts

Import the files in this order:

1. `data/01_schema.sql`
2. `data/02_data.sql`
3. `data/03_enrollments.sql`
4. `data/04_courses.sql`
5. `data/05_students.sql`
6. `data/06_departments.sql`
7. `data/07_lecturers.sql`

### 4. Configure the database connection

Update the credentials in `application/db.php` if needed:

- Host
- Username
- Password
- Database name

### 5. Run the application

Open the system in your browser:

```text
http://localhost/uovt_student_management_system/presentation/index.php
```

## Usage

- `presentation/index.php` is the main entry point and loads pages by the `page` query parameter
- Login is handled through `presentation/pages/login.php` and `application/auth.php`
- After login, the dashboard is loaded first
- All create, update, and delete actions flow through the PHP controllers in `application/`

## Workflow

The repository is intended to follow a team branching model:

- `main`: stable production-ready code
- `dev`: integration branch for team work
- `feature/*`: short-lived branches for individual tasks

Recommended branch flow:

```bash
git checkout dev
git pull origin dev
git checkout -b feature/<name>-<task>
```

Commit messages should stay focused and descriptive:

- `feat: add student form validation`
- `fix: handle duplicate email on student save`
- `docs: improve readme`

## Team

| Member Name | Student ID | Specific Contributions |
|---|---|---|
| G. B. D. Anuradha | SIS24B215 | Developed the System Dashboard, Enrollments module, Schema, ER, associated final documentation |
| L. B. Charith Jeewan | SIS24B236 | Developed the Departments module, Stored Procedures, documented the Database Normalization process |
| W. I. L. Withana | SIS24B238 | Developed the Students module (CRUD operations), associated Stored Procedures, UI integration |
| H. K. G. V. L. Koralage | SIS24B213 | Developed the Lecturers module, Views, associated Stored Procedures, associated final documentation |
| B. W. S. S. Nawarathna | SIS24B239 | Developed the Courses module, associated Stored Procedures, UI integration |

## Notes

- Keep SQL scripts and PHP controllers aligned when a table or procedure changes
- Test the affected pages after every database update
- Use prepared statements or stored procedures for database access
- Update this README whenever the folder structure or setup steps change
