-- MariaDB dump 10.19  Distrib 10.5.9-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cs304
-- ------------------------------------------------------
-- Server version	10.5.9-MariaDB-1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Account`
--

DROP TABLE IF EXISTS `Account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Account` (
  `Username` varchar(50) NOT NULL,
  `Email` varchar(320) NOT NULL,
  `RegistrationTime` datetime DEFAULT NULL,
  `PasswordHash` varchar(320) DEFAULT NULL,
  PRIMARY KEY (`Username`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Account`
--

LOCK TABLES `Account` WRITE;
/*!40000 ALTER TABLE `Account` DISABLE KEYS */;
INSERT INTO `Account` VALUES ('coolpics','coolpics@email.invalid','2021-03-31 17:33:44','$2y$10$pwfHSvJ5c55xasqgzqvfDuJlRNjl/VFlZSg97RYBdds4LMAYgOrI6'),('e e','e@e.ee','2021-03-24 00:41:20','$2y$10$5dotEaq.W8xR9trIImoEB.xMicIXwEwrxzdbWneYkdkfx60eKUMNm'),('foo','foo@com.email','2021-03-24 00:16:10','$2y$10$rEpxUjsmNKUTMgy48YXc.eK1FVObJLfXTbpdDEwfFqstvVrgg/qoa'),('foo2','foo2@a.b','2021-03-28 14:55:14','$2y$10$yFthQFSfnuJKlgNjLAOrRu/MS2HAXg/Oq19QClbTPbVMq.rGJ4af2'),('test','test@email.invalid','2021-03-31 16:48:36','$2y$10$AAlIID8erucwcb43nfGV.u1eXhknnoe8/vKAYWuo1CKOltQ4A8cxG'),('wildvoodoo','wildvoodoo@demo.account','2021-03-31 17:53:56','$2y$10$AvBmj5IcvRyr2.hN0bxJuuA9OORTpa8BX1.j3tsCB3RAG2L.Ee7Sa');
/*!40000 ALTER TABLE `Account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Album`
--

DROP TABLE IF EXISTS `Album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Album` (
  `AttachmentID` int(11) NOT NULL,
  PRIMARY KEY (`AttachmentID`),
  CONSTRAINT `Album_ibfk_1` FOREIGN KEY (`AttachmentID`) REFERENCES `Attachment` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Album`
--

LOCK TABLES `Album` WRITE;
/*!40000 ALTER TABLE `Album` DISABLE KEYS */;
INSERT INTO `Album` VALUES (9),(27),(64),(86),(89);
/*!40000 ALTER TABLE `Album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AspectRatios`
--

DROP TABLE IF EXISTS `AspectRatios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AspectRatios` (
  `Width` float NOT NULL,
  `Height` float NOT NULL,
  `AspectRatio` float DEFAULT NULL,
  PRIMARY KEY (`Width`,`Height`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AspectRatios`
--

LOCK TABLES `AspectRatios` WRITE;
/*!40000 ALTER TABLE `AspectRatios` DISABLE KEYS */;
INSERT INTO `AspectRatios` VALUES (1024,768,1.33),(1080,720,1.5),(1080,1080,1),(1280,720,1.77),(1920,1080,1.77);
/*!40000 ALTER TABLE `AspectRatios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Attachment`
--

DROP TABLE IF EXISTS `Attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Attachment` (
  `ID` int(11) NOT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `UploaderUsername` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `UploaderUsername` (`UploaderUsername`),
  CONSTRAINT `Attachment_ibfk_1` FOREIGN KEY (`UploaderUsername`) REFERENCES `Account` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Attachment`
--

LOCK TABLES `Attachment` WRITE;
/*!40000 ALTER TABLE `Attachment` DISABLE KEYS */;
INSERT INTO `Attachment` VALUES (9,'vancouver','test'),(27,'fruitsalad','foo'),(64,'wallpapers','foo'),(65,'orange','foo'),(86,'empty-test','test'),(89,'empty-test2','test'),(108,'ubc garden','test'),(133,'apple','foo'),(139,'','test'),(418,'rocket','test'),(572,'spooky fog!','coolpics'),(662,'ubc logo','test'),(672,'raindrops','coolpics'),(739,'cat montage','foo'),(743,'','test'),(770,'mainstreet','coolpics'),(777,'clouds','foo'),(778,'nightsky','foo'),(899,'','test'),(946,'cherry','coolpics'),(1001,'wild card','wildvoodoo'),(1002,'wild draw 4','wildvoodoo');
/*!40000 ALTER TABLE `Attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AttachmentTag`
--

DROP TABLE IF EXISTS `AttachmentTag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AttachmentTag` (
  `AttachmentId` int(11) NOT NULL,
  `TagName` varchar(50) NOT NULL,
  PRIMARY KEY (`AttachmentId`,`TagName`),
  KEY `TagName` (`TagName`),
  CONSTRAINT `AttachmentTag_ibfk_1` FOREIGN KEY (`AttachmentId`) REFERENCES `Attachment` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `AttachmentTag_ibfk_2` FOREIGN KEY (`TagName`) REFERENCES `Tag` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AttachmentTag`
--

LOCK TABLES `AttachmentTag` WRITE;
/*!40000 ALTER TABLE `AttachmentTag` DISABLE KEYS */;
INSERT INTO `AttachmentTag` VALUES (27,'food'),(65,'food'),(133,'food'),(572,'vancouver'),(739,'cats'),(770,'vancouver'),(946,'vancouver'),(1001,'cats'),(1001,'food'),(1001,'games'),(1001,'vancouver'),(1001,'wild'),(1002,'cats'),(1002,'food'),(1002,'games'),(1002,'vancouver'),(1002,'wild');
/*!40000 ALTER TABLE `AttachmentTag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `BelongsTo`
--

DROP TABLE IF EXISTS `BelongsTo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BelongsTo` (
  `PhotoId` int(11) NOT NULL,
  `AlbumId` int(11) NOT NULL,
  `TimeAdded` datetime DEFAULT NULL,
  PRIMARY KEY (`PhotoId`,`AlbumId`),
  KEY `AlbumId` (`AlbumId`),
  CONSTRAINT `BelongsTo_ibfk_1` FOREIGN KEY (`PhotoId`) REFERENCES `Attachment` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `BelongsTo_ibfk_2` FOREIGN KEY (`AlbumId`) REFERENCES `Attachment` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BelongsTo`
--

LOCK TABLES `BelongsTo` WRITE;
/*!40000 ALTER TABLE `BelongsTo` DISABLE KEYS */;
INSERT INTO `BelongsTo` VALUES (65,27,'2021-03-28 13:25:42'),(108,9,'2021-04-01 12:51:27'),(133,27,'2021-03-28 13:25:51'),(672,64,'2021-03-31 17:37:32'),(739,64,'2021-03-29 23:11:55'),(770,9,'2021-04-01 12:51:53'),(777,64,'2021-03-29 23:12:00'),(778,64,'2021-03-29 23:12:07'),(946,9,'2021-04-01 12:52:13');
/*!40000 ALTER TABLE `BelongsTo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CommentWrite`
--

DROP TABLE IF EXISTS `CommentWrite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CommentWrite` (
  `CommentId` int(11) NOT NULL,
  `PostId` int(11) NOT NULL,
  `Timestamp` datetime DEFAULT NULL,
  `Text` varchar(350) DEFAULT NULL,
  `SubmitterUsername` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CommentId`,`PostId`),
  KEY `PostId` (`PostId`),
  KEY `SubmitterUsername` (`SubmitterUsername`),
  CONSTRAINT `CommentWrite_ibfk_1` FOREIGN KEY (`PostId`) REFERENCES `Post` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `CommentWrite_ibfk_2` FOREIGN KEY (`SubmitterUsername`) REFERENCES `Account` (`Username`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CommentWrite`
--

LOCK TABLES `CommentWrite` WRITE;
/*!40000 ALTER TABLE `CommentWrite` DISABLE KEYS */;
INSERT INTO `CommentWrite` VALUES (1,337,'2021-03-31 23:05:00','Wow, great apple!','coolpics'),(2,226,'2021-03-31 23:20:00','Where is that??','foo'),(3,337,'2021-04-01 12:10:00','Thank you!','foo'),(4,226,'2021-04-01 12:25:00','Must be Vancouver','foo'),(5,337,'2021-04-01 12:15:00','I want one just like it','coolpics');
/*!40000 ALTER TABLE `CommentWrite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GeolocatedNames`
--

DROP TABLE IF EXISTS `GeolocatedNames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GeolocatedNames` (
  `City` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `Neighbourhood` varchar(320) NOT NULL,
  `Name` varchar(320) DEFAULT NULL,
  PRIMARY KEY (`City`,`Country`,`Neighbourhood`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GeolocatedNames`
--

LOCK TABLES `GeolocatedNames` WRITE;
/*!40000 ALTER TABLE `GeolocatedNames` DISABLE KEYS */;
INSERT INTO `GeolocatedNames` VALUES ('Burnaby','Canada','Burnaby Heights','Burnaby'),('Kingston','Canada','Kingston Downtown','Kingston'),('Ottawa','Canada','University of Ottawa','Ottawa'),('Richmond','Canada','Richmond Central','Richmond'),('Vancouver','Canada','Central Kitsilano','Kitsilano');
/*!40000 ALTER TABLE `GeolocatedNames` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Location`
--

DROP TABLE IF EXISTS `Location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Location` (
  `Latitude` float NOT NULL,
  `Longitude` float NOT NULL,
  `PostCodePrefix` varchar(50) DEFAULT NULL,
  `Country` varchar(50) DEFAULT NULL,
  `Neighbourhood` varchar(320) DEFAULT NULL,
  PRIMARY KEY (`Latitude`,`Longitude`),
  KEY `PostCodePrefix` (`PostCodePrefix`,`Country`),
  CONSTRAINT `Location_ibfk_1` FOREIGN KEY (`PostCodePrefix`, `Country`) REFERENCES `PostalCodes` (`PostCodePrefix`, `Country`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Location`
--

LOCK TABLES `Location` WRITE;
/*!40000 ALTER TABLE `Location` DISABLE KEYS */;
INSERT INTO `Location` VALUES (44.295,-76.428,'K7L','Canada','Kingston Downtown'),(45.429,-75.684,'K1N','Canada','University Ottawa'),(49.17,-123.137,'V6Y','Canada','Richmond Central'),(49.265,-123.165,'V6K','Canada','Central Kitsilano'),(49.274,-123.007,'V5C','Canada','Burnaby Heights');
/*!40000 ALTER TABLE `Location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Photo`
--

DROP TABLE IF EXISTS `Photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Photo` (
  `AttachmentID` int(11) NOT NULL,
  `URL` varchar(320) NOT NULL,
  `Latitude` float DEFAULT NULL,
  `Longitude` float DEFAULT NULL,
  `Width` float DEFAULT NULL,
  `Height` float DEFAULT NULL,
  PRIMARY KEY (`AttachmentID`),
  UNIQUE KEY `URL` (`URL`),
  KEY `Latitude` (`Latitude`,`Longitude`),
  KEY `Width` (`Width`,`Height`),
  CONSTRAINT `Photo_ibfk_1` FOREIGN KEY (`AttachmentID`) REFERENCES `Attachment` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Photo_ibfk_2` FOREIGN KEY (`Latitude`, `Longitude`) REFERENCES `Location` (`Latitude`, `Longitude`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `Photo_ibfk_3` FOREIGN KEY (`Width`, `Height`) REFERENCES `AspectRatios` (`Width`, `Height`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Photo`
--

LOCK TABLES `Photo` WRITE;
/*!40000 ALTER TABLE `Photo` DISABLE KEYS */;
INSERT INTO `Photo` VALUES (65,'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e3/Oranges_-_whole-halved-segment.jpg/1024px-Oranges_-_whole-halved-segment.jpg',NULL,NULL,NULL,NULL),(108,'https://botanicalgarden.ubc.ca/files/2020/07/garden-home1.jpg',NULL,NULL,NULL,NULL),(133,'https://upload.wikimedia.org/wikipedia/commons/5/5b/The_SugarBee_Apple_now_grown_in_Washington_State.jpg',NULL,NULL,NULL,NULL),(418,'https://openclipart.org/download/261339/big-rocket-blast-off-fat.svg',NULL,NULL,NULL,NULL),(572,'https://www.students.cs.ubc.ca/~jmlu99/cs304-project-photos/spookyfog.jpg',NULL,NULL,NULL,NULL),(662,'https://brand.ubc.ca/files/2018/09/1FullLogo_ex_768.png',NULL,NULL,NULL,NULL),(672,'https://www.students.cs.ubc.ca/~jmlu99/cs304-project-photos/raindrops.jpg',NULL,NULL,NULL,NULL),(739,'https://upload.wikimedia.org/wikipedia/commons/0/0b/Cat_poster_1.jpg',NULL,NULL,NULL,NULL),(770,'https://www.students.cs.ubc.ca/~jmlu99/cs304-project-photos/mainstreet.jpg',NULL,NULL,NULL,NULL),(777,'https://w.wallhaven.cc/full/pk/wallhaven-pk9ovp.jpg',NULL,NULL,NULL,NULL),(778,'https://w.wallhaven.cc/full/o3/wallhaven-o35599.jpg',NULL,NULL,NULL,NULL),(946,'https://www.students.cs.ubc.ca/~jmlu99/cs304-project-photos/cherry.jpg',NULL,NULL,NULL,NULL),(1001,'https://www.students.cs.ubc.ca/~jmlu99/cs304-project-photos/uno-lol/wild.jpg',NULL,NULL,NULL,NULL),(1002,'https://www.students.cs.ubc.ca/~jmlu99/cs304-project-photos/uno-lol/wild4.jpg',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Post`
--

DROP TABLE IF EXISTS `Post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Post` (
  `ID` int(11) NOT NULL,
  `CreatorUsername` varchar(50) NOT NULL,
  `AttachmentID` int(11) NOT NULL,
  `Timestamp` datetime DEFAULT NULL,
  `Slug` varchar(100) DEFAULT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Text` varchar(320) DEFAULT NULL,
  `ThemeName` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Slug` (`Slug`),
  KEY `CreatorUsername` (`CreatorUsername`),
  KEY `AttachmentID` (`AttachmentID`),
  KEY `ThemeName` (`ThemeName`),
  CONSTRAINT `Post_ibfk_1` FOREIGN KEY (`CreatorUsername`) REFERENCES `Account` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Post_ibfk_2` FOREIGN KEY (`AttachmentID`) REFERENCES `Attachment` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Post_ibfk_3` FOREIGN KEY (`ThemeName`) REFERENCES `Theme` (`Name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Post`
--

LOCK TABLES `Post` WRITE;
/*!40000 ALTER TABLE `Post` DISABLE KEYS */;
INSERT INTO `Post` VALUES (226,'coolpics',777,'2021-03-27 23:36:00',NULL,'blue sky','asfasfd',NULL),(337,'foo',133,'2021-03-28 14:05:55',NULL,'apple again','abcd',NULL),(349,'coolpics',572,'2021-03-31 17:43:04',NULL,'spooky fog','campus looks so spooky (Jan. 2019)',NULL),(369,'test',9,'2021-04-01 16:19:33',NULL,'Vancouver Photos','',NULL),(432,'foo',739,'2021-03-28 13:21:29',NULL,'cat montage!','',NULL),(589,'coolpics',770,'2021-03-27 23:35:50',NULL,'new post 1','abcdef',NULL),(631,'coolpics',572,'2021-03-27 23:35:53',NULL,'aaaaa','a',NULL),(723,'coolpics',572,'2021-03-27 23:35:54',NULL,'asfdsafa','afdas',NULL),(790,'foo',133,'2021-03-28 12:05:00',NULL,'wow an apple','asdf',NULL),(804,'foo',27,'2021-03-28 13:38:20',NULL,'fruit salad','looks yummy (totally not stolen from Wikipedia)',NULL),(926,'foo',64,'2021-03-29 23:35:45',NULL,'cool wallpapers','Here are some cool wallpapers I found',NULL);
/*!40000 ALTER TABLE `Post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PostalCodes`
--

DROP TABLE IF EXISTS `PostalCodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `PostalCodes` (
  `PostCodePrefix` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `City` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`PostCodePrefix`,`Country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PostalCodes`
--

LOCK TABLES `PostalCodes` WRITE;
/*!40000 ALTER TABLE `PostalCodes` DISABLE KEYS */;
INSERT INTO `PostalCodes` VALUES ('K1N','Canada','Ottawa'),('K7L','Canada','Kingston'),('V5C','Canada','Burnaby'),('V6K','Canada','Vancouver'),('V6Y','Canada','Richmond');
/*!40000 ALTER TABLE `PostalCodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ShareLink`
--

DROP TABLE IF EXISTS `ShareLink`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ShareLink` (
  `URL` varchar(320) NOT NULL,
  `Description` varchar(320) DEFAULT NULL,
  `CreatorUsername` varchar(50) DEFAULT NULL,
  `PostId` int(11) DEFAULT NULL,
  PRIMARY KEY (`URL`),
  KEY `CreatorUsername` (`CreatorUsername`),
  KEY `PostId` (`PostId`),
  CONSTRAINT `ShareLink_ibfk_1` FOREIGN KEY (`CreatorUsername`) REFERENCES `Account` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ShareLink_ibfk_2` FOREIGN KEY (`PostId`) REFERENCES `Post` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ShareLink`
--

LOCK TABLES `ShareLink` WRITE;
/*!40000 ALTER TABLE `ShareLink` DISABLE KEYS */;
INSERT INTO `ShareLink` VALUES ('http://localhost/hello','Wow!','foo',349),('http://localhost/apple_again','Hungry!','coolpics',337),('http://localhost/more_apple','Checkout this apple','test',337),('http:localhost/fruity_tuity','Nice fruit','coolpics',804),('http://localhost/blue','In the sky','foo',226);
/*!40000 ALTER TABLE `ShareLink` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tag`
--

DROP TABLE IF EXISTS `Tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tag` (
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tag`
--

LOCK TABLES `Tag` WRITE;
/*!40000 ALTER TABLE `Tag` DISABLE KEYS */;
INSERT INTO `Tag` VALUES ('cats'),('food'),('games'),('vancouver'),('wild');
/*!40000 ALTER TABLE `Tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Theme`
--

DROP TABLE IF EXISTS `Theme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Theme` (
  `Name` varchar(50) NOT NULL,
  `URL` varchar(320) DEFAULT NULL,
  PRIMARY KEY (`Name`),
  UNIQUE KEY `URL` (`URL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Theme`
--

LOCK TABLES `Theme` WRITE;
/*!40000 ALTER TABLE `Theme` DISABLE KEYS */;
INSERT INTO `Theme` VALUES ('Majestic Green','./themes/majestic_green'),('Passionate Purple','./themes/passionate_purple'),('Serious Red','./themes/serious_red'),('Summer Yellow','./themes/summer_yellow'),('Winter Blue','./themes/winter_blue');
/*!40000 ALTER TABLE `Theme` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-01 16:50:26
