-- Task 1 (22-46960-1): Remember Me column
-- Run once after db/travel_guide.sql

USE travel_guide;

ALTER TABLE users
ADD COLUMN remember_token VARCHAR(255) DEFAULT NULL AFTER profile_picture;
