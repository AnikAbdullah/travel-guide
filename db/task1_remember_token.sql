-- Task 1 (22-46960-1): Remember Me column
-- NOTE: remember_token is already included in travel_guide.sql.
-- Run this ONLY if you imported an older version of travel_guide.sql
-- that does not have the remember_token column.

USE travel_guide;

ALTER TABLE users
ADD COLUMN IF NOT EXISTS remember_token VARCHAR(255) DEFAULT NULL AFTER profile_picture;
