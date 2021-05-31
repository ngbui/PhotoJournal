INSERT INTO Tag VALUES ("Cat");
INSERT INTO Tag VALUES ("Beach");
INSERT INTO Tag VALUES ("Plane");
INSERT INTO Tag VALUES ("Food");
INSERT INTO Tag VALUES ("Bicycle");
-- SELECT * FROM Tag;

INSERT INTO Account Values ("user1", "user1@real.email.com", "2021-03-02 11:00:00", "password");
INSERT INTO Account Values ("user2", "user2@real.email.com", "2021-02-23 11:00:00", "password");
INSERT INTO Account Values ("user3", "user3@real.email.com", "2021-02-25 11:00:00", "password");
INSERT INTO Account Values ("user4", "user4@real.email.com", "2021-02-16 11:00:00", "password");
INSERT INTO Account Values ("user5", "user5@real.email.com", "2021-02-18 11:00:00", "password");
-- SELECT * FROM Account; 

INSERT INTO Theme Values ("Winter Blue", "./themes/winter_blue");
INSERT INTO Theme Values ("Summer Yellow", "./themes/summer_yellow");
INSERT INTO Theme Values ("Majestic Green", "./themes/majestic_green");
INSERT INTO Theme Values ("Serious Red", "./themes/serious_red");
INSERT INTO Theme Values ("Passionate Purple", "./themes/passionate_purple");
-- SELECT * FROM Theme;

INSERT INTO Attachment Values(1, "What a cat", "user1");
INSERT INTO Attachment Values(2, "Nice beach", "user1");
INSERT INTO Attachment Values(3, "View from the sky", "user2");
INSERT INTO Attachment Values(4, "Delicious", "user3");
INSERT INTO Attachment Values(5, "New bike!", "user4");
INSERT INTO Attachment Values(6, "Summer 2018", "user5");
INSERT INTO Attachment Values(7, "Times at home", "user1");
INSERT INTO Attachment Values(8, "Travelling", "user2");
INSERT INTO Attachment Values(9, "Food", "user3");
INSERT INTO Attachment Values(10, "Exercising", "user4");
-- SELECT * FROM Attachment; 

INSERT INTO PostalCodes VALUES ("V6K", "Canada", "Vancouver");
INSERT INTO PostalCodes VALUES ("V6Y", "Canada", "Richmond");
INSERT INTO PostalCodes VALUES ("V5C", "Canada", "Burnaby");
INSERT INTO PostalCodes VALUES ("K1N", "Canada", "Ottawa");
INSERT INTO PostalCodes VALUES ("K7L", "Canada", "Kingston");
-- SELECT * FROM PostalCodes;

INSERT INTO Location VALUES (49.265, -123.165, "V6K", "Canada", "Central Kitsilano");
INSERT INTO Location VALUES (49.17, -123.137, "V6Y", "Canada", "Richmond Central");
INSERT INTO Location VALUES (49.274, -123.007, "V5C", "Canada", "Burnaby Heights");
INSERT INTO Location VALUES (45.429, -75.684, "K1N", "Canada", "University Ottawa");
INSERT INTO Location VALUES (44.295, -76.428, "K7L", "Canada", "Kingston Downtown");
-- SELECT * FROM Location;

INSERT INTO GeolocatedNames VALUES ("Vancouver", "Canada", "Central Kitsilano", "Kitsilano");
INSERT INTO GeolocatedNames VALUES ("Richmond", "Canada", "Richmond Central", "Richmond");
INSERT INTO GeolocatedNames VALUES ("Burnaby", "Canada", "Burnaby Heights", "Burnaby");
INSERT INTO GeolocatedNames VALUES ("Ottawa", "Canada", "University of Ottawa", "Ottawa");
INSERT INTO GeolocatedNames VALUES ("Kingston", "Canada", "Kingston Downtown", "Kingston");
-- SELECT * FROM GeolocatedNames;

INSERT INTO Album Values(6);
INSERT INTO Album Values(7);
INSERT INTO Album Values(8);
INSERT INTO Album Values(9);
INSERT INTO Album Values(10);
-- SELECT * FROM Album;

INSERT INTO AspectRatios VALUES (1080.0, 1080.0, 1.0);
INSERT INTO AspectRatios VALUES (1080.0, 720.0, 1.5);
INSERT INTO AspectRatios VALUES (1024.0, 768.0, 1.33);
INSERT INTO AspectRatios VALUES (1920.0, 1080.0, 1.77);
INSERT INTO AspectRatios VALUES (1280.0, 720.0, 1.77);
-- SELECT * FROM AspectRatios;

INSERT INTO Photo VALUES (1, "/img/1.jpg", 49.265, -123.165, 1920.0, 1080.0);
INSERT INTO Photo VALUES (2, "/img/2.jpg", 49.274, -123.007, 1920.0, 1080.0);
INSERT INTO Photo VALUES (3, "/img/3.jpg", 49.274, -123.007, 1920.0, 1080.0);
INSERT INTO Photo VALUES (4, "/img/4.jpg", 45.429, -75.684, 1280.0, 720.0);
INSERT INTO Photo VALUES (5, "/img/5.jpg", 44.295, -76.428, 1280.0, 720.0);
-- SELECT * FROM Photo;

INSERT INTO Post VALUES (1, "user1", 1, "2021-03-02 12:00:00", "awesome_cat_1", "Awesome Cat", "Meet my cat", "Summer Yellow");
INSERT INTO Post VALUES (2, "user2", 2, "2021-03-02 12:05:00", "beach_day_1", "Beach Day", "Nice day at the beach", "Summer Yellow");
INSERT INTO Post VALUES (3, "user3", 3, "2021-03-02 12:10:00", "in_the_sky_1", "In the sky", "Airplanes are cool", "Passionate Purple");
INSERT INTO Post VALUES (4, "user3", 4, "2021-03-02 12:15:00", "restaurant_vibes_1", "Restaurant Vibes", "Very good food", "Serious Red");
INSERT INTO Post VALUES (5, "user3", 5, "2021-03-02 12:20:00", "gotta_exercise_1", "Gotta Exercise", "Stay fit everyone", "Majestic Green");
-- SELECT * FROM Post;

INSERT INTO CommentWrite VALUES (1, 1, "2021-03-02 12:05:00", "Wow, great cat!", "user2");
INSERT INTO CommentWrite VALUES (2, 1, "2021-03-02 12:10:00", "Thank you!", "user1");
INSERT INTO CommentWrite VALUES (3, 1, "2021-03-02 12:15:00", "I want one just like it", "user3");
INSERT INTO CommentWrite VALUES (1, 3, "2021-03-02 12:20:00", "Where is that??", "user1");
INSERT INTO CommentWrite VALUES (2, 3, "2021-03-02 12:25:00", "Must be Vancouver", "user4");
-- SELECT * FROM CommentWrite;

INSERT INTO ShareLink VALUES ("http://127.0.0.1:8080/awesome_cat_1-user1", "My cat", "user1", 1);
INSERT INTO ShareLink VALUES ("http://127.0.0.1:8080/awesome_cat_1-user2", "What a cat", "user2", 1);
INSERT INTO ShareLink VALUES ("http://127.0.0.1:8080/awesome_cat_1-user5", "Checkout this cat", "user5", 1);
INSERT INTO ShareLink VALUES ("http://127.0.0.1:8080/beach_day_1-user2", "Nice beach", "user2", 2);
INSERT INTO ShareLink VALUES ("http://127.0.0.1:8080/in_the_sky_1-user3", "In the sky", "user3", 3);
-- SELECT * FROM ShareLink;

INSERT INTO AttachmentTag VALUES (1, "Cat");
INSERT INTO AttachmentTag VALUES (2, "Beach");
INSERT INTO AttachmentTag VALUES (6, "Beach");
INSERT INTO AttachmentTag VALUES (5, "Bicycle");
INSERT INTO AttachmentTag VALUES (10, "Bicycle");
-- SELECT * FROM AttachmentTag;

INSERT INTO BelongsTo VALUES (1, 7, "2021-03-02 12:30:00");
INSERT INTO BelongsTo VALUES (2, 6, "2021-03-02 12:35:00");
INSERT INTO BelongsTo VALUES (3, 6, "2021-03-02 12:40:00");
INSERT INTO BelongsTo VALUES (3, 8, "2021-03-02 12:45:00");
INSERT INTO BelongsTo VALUES (4, 9, "2021-03-02 12:50:00");
INSERT INTO BelongsTo VALUES (5, 10, "2021-03-02 12:55:00");
-- SELECT * FROM BelongsTo;