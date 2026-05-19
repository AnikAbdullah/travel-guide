# Travel Guide

Web Technologies Project 01 — Travel Guide

## Team Members and Tasks

- 22-46960-1 — Task 1: Authentication, Registration, Profile, Home Page, Wishlist
- 22-48028-2 — Task 2: Scout Post Request & Information Submission
- 22-48041-2 — Task 3: Admin Dashboard, User Management, Post & Comment Moderation
- 22-48514-3 — Task 4: General User Browse, Search, Comments, Cost Estimate

## Technology

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- AJAX / JSON
- XAMPP

## Database

Database name:

travel_guide

SQL file:

db/travel_guide.sql

## Git Rules

- main branch is the final stable branch.
- Nobody pushes directly to main.
- Each student works on their own feature branch.
- Every feature must be merged into main using Pull Request.
- Each student must make at least 3 meaningful commits.
- Shared database schema must not be changed without team agreement.
- Do not overwrite another member's files.
- Pull latest main before starting work.
- No force push to main.

## Branch Names

- feature/task1-22-46960-1
- feature/task2-22-48028-2
- feature/task3-22-48041-2
- feature/task4-22-48514-3

## Task 2 — Pending Steps (22-48028-2)

After Task 1 login branch is merged into main:

1. Pull latest main into feature/task2-22-48028-2:
   git pull origin main

2. Enable scout auth in all these files by removing the bypass and uncommenting scoutOnly():
   - views/scout/dashboard.php
   - views/scout/create_request.php
   - views/scout/edit_request.php
   - views/scout/my_requests.php
   - views/scout/approved_posts.php
   - views/scout/request_changes.php

   In each file replace:
   // $scout = scoutOnly();
   $scout = ["id" => $_SESSION["user_id"] ?? 1, "name" => $_SESSION["name"] ?? "Test Scout"];

   With:
   $scout = scoutOnly();

3. Enable auth in views/scout/delete_request.php:
   Replace:
   $scoutId = (int) ($_SESSION["user_id"] ?? 1);

   With:
   $scout = scoutOnly();
   $scoutId = (int) $scout["id"];

4. Commit and push:
   git add .
   git commit -m "Enable scout auth after Task 1 merge"
   git push origin feature/task2-22-48028-2

5. Open a Pull Request from feature/task2-22-48028-2 into main on GitHub.
