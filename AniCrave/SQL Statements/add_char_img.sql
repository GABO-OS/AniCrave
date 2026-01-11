-- Create characters table if it doesn't exist
CREATE TABLE IF NOT EXISTS characters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anime_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    char_role VARCHAR(50) DEFAULT 'Main',
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (anime_id) REFERENCES anime(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insert characters for Spy x Family Season 2
INSERT INTO characters (anime_id, name, char_role, image_url)
SELECT id, 'Loid Forger', 'Main', 'img/loid-main.jpg'
FROM anime WHERE title = 'Spy x Family Season 2';

INSERT INTO characters (anime_id, name, char_role, image_url)
SELECT id, 'Anya Forger', 'Main', 'img/anya-main.jpg'
FROM anime WHERE title = 'Spy x Family Season 2';

INSERT INTO characters (anime_id, name, char_role, image_url)
SELECT id, 'Yor Forger', 'Main', 'img/yor-main.jpg'
FROM anime WHERE title = 'Spy x Family Season 2';

-- Insert characters for Attack on Titan Final Season
INSERT INTO characters (anime_id, name, char_role, image_url)
SELECT id, 'Eren Yeager', 'Main', 'https://s4.anilist.co/file/anilistcdn/media/character/large/b40882-pUnH5H0hU0vU.png'
FROM anime WHERE title = 'Attack on Titan Final Season';

INSERT INTO characters (anime_id, name, char_role, image_url)
SELECT id, 'Mikasa Ackerman', 'Main', 'https://s4.anilist.co/file/anilistcdn/media/character/large/b40881-iQY1G3UjUpAs.png'
FROM anime WHERE title = 'Attack on Titan Final Season';

-- Insert characters for Frieren: Beyond Journey\'s End
INSERT INTO characters (anime_id, name, char_role, image_url)
SELECT id, 'Frieren', 'Main', 'img/freiren-main.jfif'
FROM anime WHERE title = 'Frieren: Beyond Journey\'s End';

INSERT INTO characters (anime_id, name, char_role, image_url)
SELECT id, 'Fern', 'Main', 'img/fern-main.jpg'
FROM anime WHERE title = 'Frieren: Beyond Journey\'s End';

INSERT INTO characters (anime_id, name, char_role, image_url)
SELECT id, 'Stark', 'Main', 'img/stark-main.jfif'
FROM anime WHERE title = 'Frieren: Beyond Journey\'s End';

-- Insert characters for One Piece
INSERT INTO characters (anime_id, name, char_role, image_url)
SELECT id, 'Monkey D. Luffy', 'Main', 'img/luffy-main.jpg'
FROM anime WHERE title = 'One Piece';

INSERT INTO characters (anime_id, name, char_role, image_url)
SELECT id, 'Roronoa Zoro', 'Main', 'img/zoro-main.jpg'
FROM anime WHERE title = 'One Piece';

-- Insert characters for Solo Leveling
INSERT INTO characters (anime_id, name, char_role, image_url)
SELECT id, 'Sung Jinwoo', 'Main', 'https://s4.anilist.co/file/anilistcdn/media/character/large/b132531-h0hU0vU0vU.png'
FROM anime WHERE title = 'Solo Leveling';
