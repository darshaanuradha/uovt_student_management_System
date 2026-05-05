<div align="center">

# UOVT Student Management System

### Database-Driven Academic Management Platform

[![Status](https://img.shields.io/badge/status-active-2f855a?style=for-the-badge)](#)
[![Architecture](https://img.shields.io/badge/architecture-3--tier-1a365d?style=for-the-badge)](#architecture)
[![Backend](https://img.shields.io/badge/backend-core_php-2b6cb0?style=for-the-badge)](#technology-stack)
[![Database](https://img.shields.io/badge/database-mysql-005f73?style=for-the-badge)](#database-design-highlights)

</div>

This project was developed for the IT304082 Database Implementation module.
It is a web-based student management system built with Core PHP and MySQL,
designed around a clean 3-tier architecture and strong database engineering practices.

## Table of Contents

1. [Project Vision](#project-vision)
2. [Core Capabilities](#core-capabilities)
3. [Technology Stack](#technology-stack)
4. [Architecture](#architecture)
5. [Database Design Highlights](#database-design-highlights)
6. [Repository Structure](#repository-structure)
7. [Setup Guide](#setup-guide)
8. [Git Workflow](#git-workflow)
9. [Release Process](#release-process)
10. [Commit Convention](#commit-convention)
11. [Development Rules](#development-rules)
12. [Team](#team)
13. [Maintenance Notes](#maintenance-notes)

## Project Vision

UOVT Student Management System centralizes core academic operations in one interface.
The system currently manages:

- Departments
- Lecturers
- Courses
- Students
- Enrollments

It is built to demonstrate reliable CRUD flows, secure server-side handling,
and advanced database features that support real-world data consistency.

## Core Capabilities

- Session-based authentication
- Student CRUD operations
- Course enrollment workflow
- Server-side validation
- Prepared statements with MySQLi
- Stored procedures for reusable DB logic
- Triggers for automation and integrity
- Views for reporting and simplified querying
- Transaction support for atomic operations

## Technology Stack

- Frontend: HTML, CSS, JavaScript, TailwindCSS
- Backend: Core PHP
- Database: MySQL
- Local environment: WAMP

## Architecture

The project follows a strict 3-tier model to keep responsibilities clear and maintainable.

- Presentation Layer: UI rendering and user interaction
- Application Layer: business logic and request handling
- Data Layer: schema, routines, triggers, views, and seed data

## Database Design Highlights

The data layer includes key concepts from database engineering:

- Normalization-oriented schema design
- Stored procedures for structured operations
- Triggers for automated business rules
- Views for read-focused reporting
- Transaction handling for consistency and rollback safety

## Repository Structure

```text
uovt_student_management_system/
|-- application/
|   |-- auth.php
|   |-- actions.php
|   `-- db.php
|-- presentation/
|   |-- index.php
|   `-- dashboard.php
|-- data/
|   |-- schema.sql
|   |-- routines.sql
|   `-- data.sql
|-- docs/
|   `-- 
`-- README.md
```

## Setup Guide

### 1. Clone the repository

```bash
git clone https://github.com/darshaanuradha/uovt_student_management_System.git
cd uovt_student_management_System
```

### 2. Move project to web root

Place the project folder in:

```text
C:\wamp64\www\
```

### 3. Switch to development branch

```bash
git checkout dev
git pull origin dev
```

### 4. Create and seed the database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Run SQL files in this exact order:

1. schema.sql (database and tables)
2. routines.sql (procedures, triggers, views)
3. data.sql (sample data)

### 5. Configure database connection

Update credentials in:

```text
application/db.php
```

Set:

- Host
- Username
- Password
- Database name

### 6. Launch the application

Open in browser:

```text
http://localhost/UOVT Student Management System/presentation/index.php
```

## Git Workflow

This repository follows a team-based branching strategy.

### Branch roles

- main: production-ready code
- dev: integration branch
- feature/*: individual feature branches

### Create a feature branch

```bash
git checkout dev
git pull origin dev
git checkout -b feature/<your-name>-<feature>
```

Example names:

- feature/anuradha-auth
- feature/lakmali-dashboard
- feature/charith-procedures

### Commit and push

```bash
git add .
git commit -m "feat: add student CRUD"
git push origin feature/<your-branch>
```

### Open Pull Request

- Base branch: dev
- Compare branch: your feature branch

### Sync feature branch with latest dev

```bash
git checkout dev
git pull origin dev
git checkout feature/<your-branch>
git merge dev
```

### Delete feature branch after merge

```bash
git branch -d feature/<your-branch>
git push origin --delete feature/<your-branch>
```

## Release Process

When stable, promote changes from dev to main.

Option 1: Open Pull Request from dev to main.

Option 2: Merge manually:

```bash
git checkout main
git pull origin main
git merge dev
git push origin main
```

## Commit Convention

- feat: new feature
- fix: bug fix
- refactor: internal code improvement
- docs: documentation updates

## Development Rules

- Do not push directly to main
- Always branch from dev
- Keep features focused and small
- Use prepared statements for DB access
- Keep SQL scripts synchronized with code changes
- Maintain strict 3-tier separation

## Team

| Member Name | Student ID |
|---|---|
| G.B.D Anuradha | SIS24B215 |Dashoard,Enrollments,scheama,data,Er
| L.B Charith Jeewan |  SIS24B236 |Department, Normalization
| W.I.L Withana | SIS24B238 | Students
| H.K.G.V.L Koralage | SIS24B213 | Lectures
| B.W.S.S Nawarathna | SIS24B239 | Courses

## Maintenance Notes

- Test all affected flows after database changes
- Keep SQL scripts and PHP logic aligned
- Update this README when project structure changes
