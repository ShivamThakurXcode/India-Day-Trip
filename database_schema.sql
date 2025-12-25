-- Database schema for India Day Trip Admin Panel

CREATE DATABASE IF NOT EXISTS india_day_trip;
USE india_day_trip;

-- Users table for admin authentication
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- hashed password
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Categories table for tours and blogs
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    type ENUM('tour', 'blog') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tours table
CREATE TABLE tours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    itinerary TEXT,
    pricing DECIMAL(10,2),
    images JSON, -- array of image paths
    dates JSON, -- array of available dates
    availability INT DEFAULT 0, -- number of spots available
    category_id INT,
    location VARCHAR(255),
    duration VARCHAR(50), -- e.g., "1 Day", "5 Days"
    rating DECIMAL(3,2) DEFAULT 5.00,
    view_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_slug (slug)
);

-- Blogs table
CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content LONGTEXT,
    author VARCHAR(100),
    publication_date DATE,
    tags JSON, -- array of tags
    categories JSON, -- array of category names
    featured_image VARCHAR(255),
    view_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug)
);

-- Settings table for website settings
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123 - hashed)
INSERT INTO users (username, password, email, role) VALUES
('admin', '$2y$10$mi2N3AWZeFCP3HCJV65dMOjPeqQGphWRNjQItZ0wPz3lMOTkM4Ujm', 'admin@indiadaytrip.com', 'admin');

-- Insert sample categories
INSERT INTO categories (name, description, type) VALUES
('Same Day Tours', 'Tours completed in one day', 'tour'),
('Taj Mahal Tours', 'Tours focusing on Taj Mahal', 'tour'),
('Golden Triangle Tours', 'Delhi, Agra, Jaipur tours', 'tour'),
('Travel Tips', 'Tips and guides for travelers', 'blog'),
('Destinations', 'Information about destinations', 'blog');

-- Insert sample settings
INSERT INTO settings (setting_key, setting_value) VALUES
('contact_address', 'Shop No. 2, Gupta Market, Tajganj, Agra'),
('contact_email', 'info@indiadaytrip.com'),
('contact_mobile', '+91 81260 52755'),
('social_facebook', 'https://www.facebook.com/indiadaytrip'),
('social_twitter', 'https://www.twitter.com/indiadaytrip'),
('social_instagram', 'https://www.instagram.com/indiadaytrip');

-- Insert existing gallery images
INSERT INTO gallery_images (filename, title, tags, alt_text) VALUES
('hg1.webp', 'Gallery Image 1', '[]', 'Gallery Image 1'),
('hg2.webp', 'Gallery Image 2', '[]', 'Gallery Image 2'),
('hg3.webp', 'Gallery Image 3', '[]', 'Gallery Image 3'),
('hg4.webp', 'Gallery Image 4', '[]', 'Gallery Image 4'),
('hg5.webp', 'Gallery Image 5', '[]', 'Gallery Image 5'),
('hg6.webp', 'Gallery Image 6', '[]', 'Gallery Image 6'),
('hg7.webp', 'Gallery Image 7', '[]', 'Gallery Image 7');