# 📌 Course Module Implementation

## 🧩 Overview

Implement the **Course Module** using a 3-tier architecture within a **Modular Monolith** design:

* Presentation Layer (UI)
* Application Layer (PHP Controller)
* Data Layer (MySQL with Stored Procedures & Constraints)

---

## 🎨 1. Presentation Layer (Front-End UI)

* [x] Design **Course View Page**

  * Display all available courses in a table
  * Include actions: Edit, Delete

* [x] Apply **Green Color Theme**

  * Maintain consistent UI design across the entire application

* [x] Create `course_add_form.php`

  * Used for:

    * Insert → Create new course
    * Update → Edit course details
  * Should dynamically switch between Add/Edit modes

---

## ⚙️ 2. Application Layer (PHP Logic)

* [x] Create `courseController.php` inside `/application` folder

* [x] Implement CRUD operations:

  * Create → Add course
  * Read → Fetch course list
  * Update → Modify course details
  * Delete → Remove course

* [x] Route requests from UI → Controller → Data Layer

* [x] Ensure controller uses **Stored Procedures ONLY**

  * ❌ No direct SQL queries

---

## 🗄️ 3. Data Layer (MySQL)

* [x] Create Stored Procedures:

  * `sp_insert_course`
  * `sp_get_courses`
  * `sp_update_course`
  * `sp_delete_course`

* [x] Ensure all database operations are handled via procedures

---

## ✅ Acceptance Criteria

* Course list page displays correctly
* Add/Edit form works using a single file
* Stored procedures execute correctly
* No raw SQL queries in controller

---

## 👤 Assignee

* [ ] Assign team member

## 🏷️ Labels

`enhancement` `backend` `frontend` `database`
