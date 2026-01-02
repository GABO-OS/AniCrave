-- Add anime_title column to favorites table
ALTER TABLE favorites ADD COLUMN anime_title VARCHAR(255) AFTER anime_id;

-- Populate experimental anime_title column from existing anime data
UPDATE favorites f 
JOIN anime a ON f.anime_id = a.id 
SET f.anime_title = a.title;
