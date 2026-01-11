-- AniCrave Database Schema
-- Database: anicrave
-- This file contains the database structure for the AniCrave website.

-- ==========================================================================
-- Table: user
-- Description: Stores registered user account information including login credentials and profile details.
-- Relationships:
--   - 1:N (One-to-Many) with 'favorites': A single user can have multiple entries in the favorites list.
-- ==========================================================================

CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,        -- Unique ID for each user (Primary Key)
  username VARCHAR(255) NOT NULL UNIQUE KEY,         -- Unique login username
  email VARCHAR(255) NOT NULL UNIQUE KEY,            -- Unique email address
  password_hashed VARCHAR(255) NOT NULL,             -- Securely hashed password
  role VARCHAR(20) DEFAULT 'user',                   -- User role (admin/user)
  gender VARCHAR(50) DEFAULT NULL,                   -- User gender (Optional)
  birthday DATE DEFAULT NULL,                        -- User birthdate (Optional)
  contact VARCHAR(20) DEFAULT NULL,                  -- Contact number (Optional)
  bio TEXT DEFAULT NULL,                             -- Short user biography
  profile_picture VARCHAR(255) DEFAULT NULL,         -- Path to profile image
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp() -- Account creation timestamp
) ENGINE=InnoDB;

-- ==========================================================================
-- Table: anime
-- Description: The main catalog of anime series/movies available on the platform.
-- Relationships:
--   - 1:N (One-to-Many) with 'favorites': An anime can be favorited by multiple users.
--   - 1:N (One-to-Many) with 'characters': An anime series has multiple associated characters.
-- ==========================================================================

CREATE TABLE anime (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,        -- Unique ID for each anime
  title VARCHAR(255) NOT NULL,                       -- Anime title
  cover_image VARCHAR(255) NOT NULL,                 -- URL/Path for the main cover image (Portrait)
  banner_image VARCHAR(255) DEFAULT NULL,            -- URL/Path for the banner image (Landscape)
  description TEXT DEFAULT NULL,                     -- Synopsis or story summary
  genres VARCHAR(255) DEFAULT NULL,                  -- Comma-separated list of genres (e.g., Action, Fantasy)
  year INT DEFAULT NULL,                             -- Release year
  season VARCHAR(20) DEFAULT NULL,                   -- Release season (Winter, Spring, Summer, Fall)
  type VARCHAR(20) DEFAULT 'TV',                     -- Format (TV, Movie, OVA, etc.)
  status ENUM('Completed', 'Ongoing', 'Upcoming'),   -- Airing status
  episodes INT DEFAULT 0,                            -- Total number of episodes
  average_score INT DEFAULT 0,                       -- Average rating (0-100)
  studio VARCHAR(255) DEFAULT NULL,                  -- Animation studio
  section VARCHAR(50) DEFAULT 'NONE',                -- UI Section (PICK BY ADMIN, TRENDING NOW, etc.)
  INDEX (title)                                      -- Index for faster search by title
)

-- ==========================================================================
-- Table: favorites
-- Description: A junction table that links users to their favorite anime.
-- Relationships:
--   - Belongs to 'user' (user_id): Links to the user who added the favorite.
--   - Belongs to 'anime' (anime_id): Links to the anime defined as a favorite.
-- ==========================================================================

CREATE TABLE favorites (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,                             -- Foreign Key: Links to user.id
  anime_id INT NOT NULL,                            -- Foreign Key: Links to anime.id
  anime_title VARCHAR(255) DEFAULT NULL,            -- Denormalized title for easier display
  added_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  UNIQUE KEY unique_favorite (user_id, anime_id),   -- Constraint: A user can only favorite an anime once
  KEY `user_id` (`user_id`),
  KEY `anime_id` (`anime_id`),
  
  -- Foreign Key Constraints
  CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`anime_id`) REFERENCES `anime` (`id`) ON DELETE CASCADE
)
-- ==========================================================================
-- Table: characters
-- Description: Stores information about characters appearing in specific anime series.
-- Relationships:
--   - Belongs to 'anime' (anime_id): Each character is associated with one specific anime series.
-- ==========================================================================

CREATE TABLE characters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anime_id INT NOT NULL,                          -- Foreign Key: Links to anime.id
    name VARCHAR(255) NOT NULL,                     -- Character name
    char_role VARCHAR(50) DEFAULT 'Main',                -- Role type (Main, Supporting)
    image_url VARCHAR(255) NOT NULL,                -- URL/Path for character image
    
    -- Foreign Key Constraint
    FOREIGN KEY (anime_id) REFERENCES anime(id) ON DELETE CASCADE
);

-- ==========================================================================
-- DATABASE RELATIONSHIPS (ERD)
-- In Mermaid syntax for visualization:
/*
erDiagram
    USERS ||--o{ FAVORITES : "has"
    ANIME ||--o{ FAVORITES : "belongs to"
    ANIME ||--o{ CHARACTERS : "contains"

    USERS {
        int id PK
        string role
    }

    ANIME {
        int id PK
        string title
        string section
    }

    FAVORITES {
        int id PK
        int user_id FK
        int anime_id FK
    }

    CHARACTERS {
        int id PK
        int anime_id FK
        string name
    }
*/
-- ==========================================================================
