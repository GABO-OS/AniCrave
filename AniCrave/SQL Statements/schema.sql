AniCrave Database Schema
Database: anicrave

Table Structure for table `signup` (Users)
--

CREATE TABLE signup (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE KEY,
  email VARCHAR(255) NOT NULL UNIQUE KEY,
  password_hashed VARCHAR(255) NOT NULL,
  gender VARCHAR(50) DEFAULT NULL,
  birthday DATE DEFAULT NULL,
  contact VARCHAR(20) DEFAULT NULL,
  bio TEXT DEFAULT NULL,
  profile_picture VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB;

Table structure for table `anime`

CREATE TABLE anime (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  cover_image VARCHAR(255) NOT NULL,
  banner_image VARCHAR(255) DEFAULT NULL,
  description TEXT DEFAULT NULL,
  genres VARCHAR(255) DEFAULT NULL,
  year INT DEFAULT NULL,
  season VARCHAR(20) DEFAULT NULL,
  type VARCHAR(20) DEFAULT 'TV',
  status ENUM('Completed', 'Ongoing', 'Upcoming'),
  INDEX (title)
) ENGINE=InnoDB;

Table Structure for table `favorites`

CREATE TABLE favorites (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  anime_id INT NOT NULL,
  anime_title VARCHAR(255) DEFAULT NULL,
  added_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY unique_favorite (user_id, anime_id),
  KEY `user_id` (`user_id`),
  KEY `anime_id` (`anime_id`),
  CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `signup` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

Table Structure for table `characters`

CREATE TABLE characters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anime_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'Main',
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (anime_id) REFERENCES anime(id) ON DELETE CASCADE
) ENGINE=InnoDB;