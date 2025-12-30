-- SQL Script to update anime descriptions, banners, and stats
-- Run this to populate the details pages with the correct content

-- Frieren: Beyond Journey's End
UPDATE anime 
SET 
  banner_image = 'img/freiren-banner.jpg',
  cover_image = 'img/freiren.jpg',
  description = "The Demon King has been defeated, and the victorious party returns home before disbanding. The four heroes—mage Frieren, hero Himmel, priest Heiter, and warrior Eisen—reminisce about their decade-long journey as the moment to bid each other farewell arrives. But the passing of time is different for elves, thus Frieren witnesses her companions slowly pass away one by one.<br><br>Before his death, Heiter manages to foist a young human apprentice called Fern onto Frieren. Driven by the elf's passion for collecting a myriad of magic spells, the pair embarks on a seemingly aimless journey, revisiting the places that the heroes of yore had visited. Along their travels, Frieren slowly confronts her regrets of missed opportunities to form deeper bonds with her now-deceased comrades.",
  genres = 'Adventure, Drama, Fantasy',
  year = 2023,
  season = 'Fall',
  type = 'TV',
  status = 'Finished'
WHERE title = "Frieren: Beyond Journey's End";

-- Spy x Family Season 2
UPDATE anime 
SET 
  banner_image = 'img/spyfam-banner.png',
  cover_image = 'img/spyfam.jfif',
  description = "Peace at the nations of Ostania and Westalis is a precarious thing. To maintain it, the master spy \"Twilight\" must take on his most difficult mission yet: get married, have a kid, and play family.<br><br>In this second season, the Forger family continues their secret lives while navigating the challenges of everyday life and undercover missions. Anya's school life at Eden Academy becomes more intense as she strives to help Loid with Operation Strix, while Yor's secret life as the \"Thorn Princess\" leads to unexpected complications.",
  genres = 'Action, Comedy',
  year = 2023,
  season = 'Fall',
  type = 'TV',
  status = 'Finished'
WHERE title = "Spy x Family Season 2";

-- The Apothecary Diaries
UPDATE anime 
SET 
  banner_image = 'img/diaries-banner.jpg',
  cover_image = 'img/diaries.jpg',
  description = "Maomao lived a peaceful life with her apothecary father. Until she was sold as a lowly servant to the emperor's palace. But she wasn't meant for a compliant life among royalty. So when imperial heirs fall ill, she decides to step in and find a cure! This catches the eye of Jinshi, a handsome palace official who promotes her. Now, she's making a name for herself solving medical mysteries!",
  genres = 'Drama, Mystery',
  year = 2023,
  season = 'Fall',
  type = 'TV',
  status = 'Finished'
WHERE title = "The Apothecary Diaries";

-- Shangri-La Frontier
UPDATE anime 
SET 
  banner_image = 'img/shangri-la-banner.webp',
  cover_image = 'img/shangri-la.jpg',
  description = "Rakuro Hizutome, a high schooler who loves \"trash games,\" decides to challenge \"Shangri-La Frontier,\" a \"god-tier game\" with 30 million players.<br><br>Armed with the skills he's honed from playing countless broken games, Rakuro (as his avatar Sunraku) dives into the world of SLF. He soon finds himself embroiled in epic battles against legendary monsters and uncovering the deep secrets of the game's vast world.",
  genres = 'Action, Adventure, Fantasy',
  year = 2023,
  season = 'Fall',
  type = 'TV',
  status = 'Ongoing'
WHERE title = "Shangri-La Frontier";

-- Solo Leveling
UPDATE anime 
SET 
  banner_image = 'img/solo leveling.avif',
  cover_image = 'img/solo leveling-banner.jpg',
  description = "In a world where hunters, humans who possess magical abilities, must battle deadly monsters to protect mankind from certain annihilation, a notoriously weak hunter named Sung Jinwoo finds himself in a seemingly endless struggle for survival.<br><br>One day, after narrowly surviving an overwhelmingly powerful double dungeon that nearly wipes out his entire party, a mysterious program called the System chooses him as its sole player and in turn, gives him the extremely rare ability to level up in strength, possibly beyond any known limits.",
  genres = 'Action, Adventure, Fantasy',
  year = 2024,
  season = 'Winter',
  type = 'TV',
  status = 'Finished'
WHERE title = "Solo Leveling";

-- Attack on Titan Final Season
UPDATE anime 
SET 
  banner_image = 'img/aot-banner.jpg',
  cover_image = 'img/aot.jpeg',
  description = "The world outside the walls is revealed, and it's far from the paradise the people of Paradis Island imagined. As the conflict between the Eldians and the Marleyans reaches its breaking point, Eren Yeager embarks on a radical path that will change the fate of both nations forever.<br><br>This final season follows the descent into chaos as former allies become enemies and once-simple beliefs are shattered. The battle for survival transcends walls, and the true nature of the Titans is finally unveiled in an epic, world-shaking conclusion.",
  genres = 'Action, Drama, Fantasy',
  year = 2023,
  season = 'Fall',
  type = 'TV',
  status = 'Finished'
WHERE title = "Attack on Titan Final Season";

-- One Piece
UPDATE anime 
SET 
  banner_image = 'img/op-banner.jpg',
  cover_image = 'img/op.avif',
  description = "Monkey D. Luffy, a boy whose body gained the properties of rubber after unintentionally eating a Devil Fruit, sets off from the East Blue Sea in search of the titular \"One Piece\" treasure and to claim the title of King of the Pirates.<br><br>Along his journey, he recruits a diverse crew, the Straw Hat Pirates, including a swordsman, a navigator, a sniper, a cook, a doctor, an archaeologist, a shipwright, a musician, and a helmsman. Together, they face powerful enemies and explore the vast, wondrous world of the Grand Line.",
  genres = 'Action, Adventure, Comedy, Fantasy',
  year = 1999,
  season = NULL,
  type = 'TV',
  status = 'Ongoing'
WHERE title = "One Piece";

-- Jujutsu Kaisen 2nd Season
UPDATE anime 
SET 
  banner_image = 'img/jjk-banner.jpg',
  cover_image = 'img/jjk.jpg',
  description = "The second season of Jujutsu Kaisen covers two major arcs: \"Hidden Inventory\" and \"Shibuya Incident.\" It begins by exploring Gojo Satoru and Geto Suguru's past as students at Jujutsu High, and the tragic events that led to their divergence.<br><br>Then, it transitions into the present day for the \"Shibuya Incident,\" where a massive curse-fueled conspiracy unfolds in the heart of Tokyo. Itadori Yuuji and his fellow sorcerers are thrown into a battle of unprecedented scale, where the stakes are higher than ever before.",
  genres = 'Action, Fantasy',
  year = 2023,
  season = 'Summer',
  type = 'TV',
  status = 'Finished'
WHERE title = "Jujutsu Kaisen 2nd Season";

-- Kimetsu no Yaiba: Swordsmith Village Arc
UPDATE anime 
SET 
  banner_image = 'img/demon-banner.webp',
  cover_image = 'img/demon.jpg',
  description = "Tanjiro's journey leads him to the Swordsmith Village, where he must have his sword repaired by the legendary smith, Hotaru Haganezuka.<br><br>However, danger follows as Upper Rank demons from Muzan Kibutsuji's elite appear to lay waste to the village. Tanjiro, alongside the Love Hashira Mitsuri Kanroji and the Mist Hashira Muichiro Tokito, must defend the smiths and uncover new strengths to survive the onslaught.",
  genres = 'Action, Fantasy',
  year = 2023,
  season = 'Spring',
  type = 'TV',
  status = 'Finished'
WHERE title = "Kimetsu no Yaiba: Swordsmith Village Arc";

-- Mushoku Tensei: Jobless Reincarnation Season 2
UPDATE anime 
SET 
  banner_image = 'img/tensei-banner.webp',
  cover_image = 'img/tensei.webp',
  description = "Rudeus Greyrat's journey continues in the second season, as he deals with the aftermath of the Mana Calamity and his separation from Eris. Now heading north, he aims to find his mother, Zenith, while carving out a name for himself as a powerful adventurer.<br><br>This season focuses on Rudeus's growth as an individual, his experiences at the Ranoa Academy of Magic, and his reunion with familiar faces from his past. The world continues to expand, revealing more of its rich history and the complex lives of those who inhabit it.",
  genres = 'Adventure, Drama, Fantasy',
  year = 2023,
  season = 'Summer',
  type = 'TV',
  status = 'Finished'
WHERE title = "Mushoku Tensei: Jobless Reincarnation Season 2";
