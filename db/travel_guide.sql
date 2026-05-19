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
    remember_token VARCHAR(255) DEFAULT NULL,
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
    updated_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (scout_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);

CREATE TABLE post_requests(
    id INT AUTO_INCREMENT PRIMARY KEY,
    scout_id INT NOT NULL,
    post_data JSON NOT NULL,
    requested_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,
    status ENUM(
        'pending',
        'approved',
        'rejected'
    ) NOT NULL DEFAULT 'pending',

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
VALUES
(
    'Admin',
    'admin@travel.com',
    '$2y$10$ulv2DIY2qG52K6SjMXqPLeYJJwIKn4rmF6LhJ4kV5ILW3JqY3iDSC',
    'admin',
    1
),
(
    'Test Scout',
    'scout@travel.com',
    '$2y$10$ulv2DIY2qG52K6SjMXqPLeYJJwIKn4rmF6LhJ4kV5ILW3JqY3iDSC',
    'scout',
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
    2,
    'Coxs Bazar',
    'Longest Sea Beach In The World',
    'Bangladesh',
    'beach',
    'medium',
    'Bus, Flight',
    'approved'
),
(
    2,
    'Sajek Valley',
    'Beautiful Hill Area',
    'Bangladesh',
    'mountain',
    'low',
    'Bus, Jeep',
    'approved'
);
