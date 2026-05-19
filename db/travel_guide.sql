CREATE DATABASE IF NOT EXISTS travel_guide;

USE travel_guide;

CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM(
        'admin',
        'scout',
        'user'
    ) NOT NULL,
    is_verified TINYINT(1) DEFAULT 0,
    profile_picture VARCHAR(255),
    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts(
    id INT AUTO_INCREMENT PRIMARY KEY,
    scout_id INT,
    title VARCHAR(255),
    short_history TEXT,
    country VARCHAR(100),
    genre VARCHAR(100),
    cost_level ENUM(
        'low',
        'medium',
        'high'
    ),
    travel_medium_info TEXT,
    status ENUM(
        'pending',
        'approved',
        'rejected'
    ),
    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (scout_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);

CREATE TABLE wishlist(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    post_id INT,
    added_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY(post_id)
    REFERENCES posts(id)
    ON DELETE CASCADE
);

INSERT INTO users(
    name,
    email,
    password_hash,
    role,
    is_verified
)
VALUES(
    'Admin',
    'admin@travel.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/.V3Dbpr9Fqvle',
    'admin',
    1
);

INSERT INTO posts(
    scout_id,
    title,
    short_history,
    country,
    genre,
    cost_level,
    travel_medium_info,
    status
)
VALUES
(
    1,
    'Coxs Bazar',
    'Longest Sea Beach In The World',
    'Bangladesh',
    'Beach',
    'medium',
    'Bus, Flight',
    'approved'
),
(
    1,
    'Sajek Valley',
    'Beautiful Hill Area',
    'Bangladesh',
    'Mountain',
    'low',
    'Bus, Jeep',
    'approved'
);
