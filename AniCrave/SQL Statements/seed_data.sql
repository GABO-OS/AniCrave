-- AniCrave Seed Data Script
-- This script populates the database with initial data for testing and development.
-- Database: anicrave

-- 1. CLEANUP (Optional: Uncomment if you want to clear existing data)
-- SET FOREIGN_KEY_CHECKS = 0;
-- TRUNCATE TABLE favorites;
-- TRUNCATE TABLE characters;
-- TRUNCATE TABLE anime;
-- TRUNCATE TABLE users;
-- SET FOREIGN_KEY_CHECKS = 1;

-- 2. INSERT USERS
-- Password for all users: "password123" (Hashed)
INSERT INTO users (username, email, password_hashed, role, bio) VALUES
('admin', 'admin@anicrave.com', '$2y$10$8W3Y6uM1m1eX.9hK4yP.oeV.x4Yq/4x/WcEqq3k5P2Xz.X.F5xI0S', 'admin', 'System Administrator of AniCrave.'),
('maureen', 'maureen@example.com', '$2y$10$8W3Y6uM1m1eX.9hK4yP.oeV.x4Yq/4x/WcEqq3k5P2Xz.X.F5xI0S', 'user', 'Anime lover and casual watcher.');

-- 3. INSERT ANIME
INSERT INTO anime (title, cover_image, banner_image, description, genres, year, season, type, status) VALUES
("Frieren: Beyond Journey's End", 'img/freiren.jpg', 'img/freiren-banner.jpg', "The Demon King has been defeated, and the victorious party returns home before disbanding. The four heroes—mage Frieren, hero Himmel, priest Heiter, and warrior Eisen—reminisce about their decade-long journey as the moment to bid each other farewell arrives. But the passing of time is different for elves, thus Frieren witnesses her companions slowly pass away one by one.<br><br>Before his death, Heiter manages to foist a young human apprentice called Fern onto Frieren. Driven by the elf's passion for collecting a myriad of magic spells, the pair embarks on a seemingly aimless journey, revisiting the places that the heroes of yore had visited. Along their travels, Frieren slowly confronts her regrets of missed opportunities to form deeper bonds with her now-deceased comrades.", 'Adventure, Drama, Fantasy', 2023, 'Fall', 'TV', 'Completed'),

("Spy x Family Season 2", 'img/spyfam.jfif', 'img/spyfam-banner.png', "Peace at the nations of Ostania and Westalis is a precarious thing. To maintain it, the master spy \"Twilight\" must take on his most difficult mission yet: get married, have a kid, and play family.<br><br>In this second season, the Forger family continues their secret lives while navigating the challenges of everyday life and undercover missions. Anya's school life at Eden Academy becomes more intense as she strives to help Loid with Operation Strix, while Yor's secret life as the \"Thorn Princess\" leads to unexpected complications.", 'Action, Comedy', 2023, 'Fall', 'TV', 'Completed'),

("The Apothecary Diaries", 'img/diaries.jpg', 'img/diaries-banner.jpg', "Maomao lived a peaceful life with her apothecary father. Until she was sold as a lowly servant to the emperor's palace. But she wasn't meant for a compliant life among royalty. So when imperial heirs fall ill, she decides to step in and find a cure! This catches the eye of Jinshi, a handsome palace official who promotes her. Now, she's making a name for herself solving medical mysteries!", 'Drama, Mystery', 2023, 'Fall', 'TV', 'Completed'),

("Shangri-La Frontier", 'img/shangri-la.jpg', 'img/shangri-la-banner.webp', "Rakuro Hizutome, a high schooler who loves \"trash games,\" decides to challenge \"Shangri-La Frontier,\" a \"god-tier game\" with 30 million players.<br><br>Armed with the skills he's honed from playing countless broken games, Rakuro (as his avatar Sunraku) dives into the world of SLF. He soon finds himself embroiled in epic battles against legendary monsters and uncovering the deep secrets of the game's vast world.", 'Action, Adventure, Fantasy', 2023, 'Fall', 'TV', 'Ongoing'),

("Solo Leveling", 'img/solo leveling-banner.jpg', 'img/solo leveling.avif', "In a world where hunters, humans who possess magical abilities, must battle deadly monsters to protect mankind from certain annihilation, a notoriously weak hunter named Sung Jinwoo finds himself in a seemingly endless struggle for survival.<br><br>One day, after narrowly surviving an overwhelmingly powerful double dungeon that nearly wipes out his entire party, a mysterious program called the System chooses him as its sole player and in turn, gives him the extremely rare ability to level up in strength, possibly beyond any known limits.", 'Action, Adventure, Fantasy', 2024, 'Winter', 'TV', 'Completed'),

("Attack on Titan Final Season", 'img/aot.jpeg', 'img/aot-banner.jpg', "The world outside the walls is revealed, and it's far from the paradise the people of Paradis Island imagined. As the conflict between the Eldians and the Marleyans reaches its breaking point, Eren Yeager embarks on a radical path that will change the fate of both nations forever.<br><br>This final season follows the descent into chaos as former allies become enemies and once-simple beliefs are shattered. The battle for survival transcends walls, and the true nature of the Titans is finally unveiled in an epic, world-shaking conclusion.", 'Action, Drama, Fantasy', 2023, 'Fall', 'TV', 'Completed'),

("One Piece", 'img/op.avif', 'img/op-banner.jpg', "Monkey D. Luffy, a boy whose body gained the properties of rubber after unintentionally eating a Devil Fruit, sets off from the East Blue Sea in search of the titular \"One Piece\" treasure and to claim the title of King of the Pirates.<br><br>Along his journey, he recruits a diverse crew, the Straw Hat Pirates, including a swordsman, a navigator, a sniper, a cook, a doctor, an archaeologist, a shipwright, a musician, and a helmsman. Together, they face powerful enemies and explore the vast, wondrous world of the Grand Line.", 'Action, Adventure, Comedy, Fantasy', 1999, NULL, 'TV', 'Ongoing'),

("Jujutsu Kaisen 2nd Season", 'img/jjk.jpg', 'img/jjk-banner.jpg', "The second season of Jujutsu Kaisen covers two major arcs: \"Hidden Inventory\" and \"Shibuya Incident.\" It begins by exploring Gojo Satoru and Geto Suguru's past as students at Jujutsu High, and the tragic events that led to their divergence.<br><br>Then, it transitions into the present day for the \"Shibuya Incident,\" where a massive curse-fueled conspiracy unfolds in the heart of Tokyo. Itadori Yuuji and his fellow sorcerers are thrown into a battle of unprecedented scale, where the stakes are higher than ever before.", 'Action, Fantasy', 2023, 'Summer', 'TV', 'Completed'),

("Kimetsu no Yaiba: Swordsmith Village Arc", 'img/demon.jpg', 'img/demon-banner.webp', "Tanjiro's journey leads him to the Swordsmith Village, where he must have his sword repaired by the legendary smith, Hotaru Haganezuka.<br><br>However, danger follows as Upper Rank demons from Muzan Kibutsuji's elite appear to lay waste to the village. Tanjiro, alongside the Love Hashira Mitsuri Kanroji and the Mist Hashira Muichiro Tokito, must defend the smiths and uncover new strengths to survive the onslaught.", 'Action, Fantasy', 2023, 'Spring', 'TV', 'Completed'),

("Mushoku Tensei: Jobless Reincarnation Season 2", 'img/tensei.webp', 'img/tensei-banner.webp', "Rudeus Greyrat's journey continues in the second season, as he deals with the aftermath of the Mana Calamity and his separation from Eris. Now heading north, he aims to find his mother, Zenith, while carving out a name for himself as a powerful adventurer.<br><br>This season focuses on Rudeus's growth as an individual, his experiences at the Ranoa Academy of Magic, and his reunion with familiar faces from his past. The world continues to expand, revealing more of its rich history and the complex lives of those who inhabit it.", 'Adventure, Drama, Fantasy', 2023, 'Summer', 'TV', 'Completed');

-- 4. INSERT CHARACTERS
-- Using Subqueries to get the correct anime_id based on the title

-- Frieren
INSERT INTO characters (anime_id, name, char_role, image_url) VALUES
((SELECT id FROM anime WHERE title = "Frieren: Beyond Journey's End"), 'Frieren', 'Main', 'img/freiren-main.jfif'),
((SELECT id FROM anime WHERE title = "Frieren: Beyond Journey's End"), 'Fern', 'Main', 'img/fern-main.jpg'),
((SELECT id FROM anime WHERE title = "Frieren: Beyond Journey's End"), 'Stark', 'Main', 'img/stark-main.jfif');

-- Spy x Family
INSERT INTO characters (anime_id, name, char_role, image_url) VALUES
((SELECT id FROM anime WHERE title = 'Spy x Family Season 2'), 'Loid Forger', 'Main', 'img/loid-main.jpg'),
((SELECT id FROM anime WHERE title = 'Spy x Family Season 2'), 'Anya Forger', 'Main', 'img/anya-main.jpg'),
((SELECT id FROM anime WHERE title = 'Spy x Family Season 2'), 'Yor Forger', 'Main', 'img/yor-main.jpg');

-- The Apothecary Diaries
INSERT INTO characters (anime_id, name, char_role, image_url) VALUES
((SELECT id FROM anime WHERE title = 'The Apothecary Diaries'), 'Maomao', 'Main', 'img/maomao-main.jpg'),
((SELECT id FROM anime WHERE title = 'The Apothecary Diaries'), 'Jinshi', 'Main', 'img/jinshi-main.webp');

-- Shangri-La Frontier
INSERT INTO characters (anime_id, name, char_role, image_url) VALUES
((SELECT id FROM anime WHERE title = 'Shangri-La Frontier'), 'Sunraku', 'Main', 'img/sunraku-main.webp'),
((SELECT id FROM anime WHERE title = 'Shangri-La Frontier'), 'Saiga-0', 'Main', 'img/saiga-main.jpg');

-- Solo Leveling
INSERT INTO characters (anime_id, name, char_role, image_url) VALUES
((SELECT id FROM anime WHERE title = 'Solo Leveling'), 'Sung Jinwoo', 'Main', 'https://s4.anilist.co/file/anilistcdn/media/character/large/b132531-h0hU0vU0vU.png');

-- Attack on Titan
INSERT INTO characters (anime_id, name, char_role, image_url) VALUES
((SELECT id FROM anime WHERE title = 'Attack on Titan Final Season'), 'Eren Yeager', 'Main', 'https://s4.anilist.co/file/anilistcdn/media/character/large/b40882-pUnH5H0hU0vU.png'),
((SELECT id FROM anime WHERE title = 'Attack on Titan Final Season'), 'Mikasa Ackerman', 'Main', 'https://s4.anilist.co/file/anilistcdn/media/character/large/b40881-iQY1G3UjUpAs.png');

-- One Piece
INSERT INTO characters (anime_id, name, char_role, image_url) VALUES
((SELECT id FROM anime WHERE title = 'One Piece'), 'Monkey D. Luffy', 'Main', 'img/luffy-main.jpg'),
((SELECT id FROM anime WHERE title = 'One Piece'), 'Roronoa Zoro', 'Main', 'img/zoro-main.jpg');

-- Jujutsu Kaisen
INSERT INTO characters (anime_id, name, char_role, image_url) VALUES
((SELECT id FROM anime WHERE title = 'Jujutsu Kaisen 2nd Season'), 'Yuuji Itadori', 'Main', 'img/itadori-main.webp'),
((SELECT id FROM anime WHERE title = 'Jujutsu Kaisen 2nd Season'), 'Satoru Gojo', 'Main', 'img/gojo-main.jpg');

-- Demon Slayer
INSERT INTO characters (anime_id, name, char_role, image_url) VALUES
((SELECT id FROM anime WHERE title = 'Kimetsu no Yaiba: Swordsmith Village Arc'), 'Tanjiro Kamado', 'Water/Sun Breathing', 'img/tanjiro-main.webp'),
((SELECT id FROM anime WHERE title = 'Kimetsu no Yaiba: Swordsmith Village Arc'), 'Nezuko Kamado', 'Demon Sister', 'img/nezuko-main.jpg'),
((SELECT id FROM anime WHERE title = 'Kimetsu no Yaiba: Swordsmith Village Arc'), 'Zenitsu Agatsuma', 'Thunder Breathing', 'img/zenitsu-main.jpg'),
((SELECT id FROM anime WHERE title = 'Kimetsu no Yaiba: Swordsmith Village Arc'), 'Inosuke Hashibira', 'Beast Breathing', 'img/inosuke-main.jpg');

-- Mushoku Tensei
INSERT INTO characters (anime_id, name, char_role, image_url) VALUES
((SELECT id FROM anime WHERE title = 'Mushoku Tensei: Jobless Reincarnation Season 2'), 'Rudeus Greyrat', 'Main', 'img/rudeus-main.webp'),
((SELECT id FROM anime WHERE title = 'Mushoku Tensei: Jobless Reincarnation Season 2'), 'Sylphiette', 'Main', 'img/sylphie-main.jpg');

-- 5. INSERT SAMPLE FAVORITES
-- maureen (id 2) favorites Frieren (id 1) and Solo Leveling (id 5)
INSERT INTO favorites (user_id, anime_id, anime_title) VALUES
(2, (SELECT id FROM anime WHERE title = "Frieren: Beyond Journey's End"), "Frieren: Beyond Journey's End"),
(2, (SELECT id FROM anime WHERE title = "Solo Leveling"), "Solo Leveling");
