CREATE TABLE Tag (
	Name VARCHAR(50) PRIMARY KEY
);

CREATE TABLE Account (
Username VARCHAR(50) PRIMARY KEY,
    	Email VARCHAR(320) UNIQUE NOT NULL,
    	RegistrationTime DATETIME,
    	PasswordHash VARCHAR(320)
);

CREATE TABLE Theme (
	Name VARCHAR(50) PRIMARY KEY,
URL VARCHAR(320) UNIQUE
);

CREATE TABLE Attachment (
	ID INTEGER PRIMARY KEY,
    	Title VARCHAR(100),
    	UploaderUsername VARCHAR(50) NOT NULL,
    	FOREIGN KEY (UploaderUsername) 
		REFERENCES Account(Username)
			ON DELETE CASCADE
           			ON UPDATE CASCADE
);

CREATE TABLE PostalCodes (
	PostCodePrefix VARCHAR(50),
    Country VARCHAR(50),
    City VARCHAR(50),
    PRIMARY KEY (PostCodePrefix, Country)
);

CREATE TABLE Location (
	Latitude FLOAT,
	Longitude FLOAT,
	PostCodePrefix VARCHAR(50),
    Country VARCHAR(50),
    Neighbourhood VARCHAR(320),
	PRIMARY KEY (Latitude, Longitude),
    FOREIGN KEY (PostCodePrefix, Country)
		REFERENCES PostalCodes(PostCodePrefix, Country)
			ON DELETE CASCADE
            ON UPDATE CASCADE
);

CREATE TABLE GeolocatedNames (
	City VARCHAR(50),
    Country VARCHAR(50),
    Neighbourhood VARCHAR(320),
    Name VARCHAR(320),
    PRIMARY KEY (City, Country, Neighbourhood)
    -- FOREIGN KEY (Country)
-- 		REFERENCES PostalCodes(Country)
-- 			ON DELETE CASCADE
--             ON UPDATE CASCADE,
-- 	FOREIGN KEY (City)
-- 		REFERENCES PostalCodes(City)
-- 			ON DELETE CASCADE
--             ON UPDATE CASCADE,
-- 	FOREIGN KEY (Neighbourhood)
-- 		REFERENCES Location(Neighbourhood)
-- 			ON DELETE CASCADE
--             ON UPDATE CASCADE
);

CREATE TABLE Album (
	AttachmentID INTEGER PRIMARY KEY,
   	 FOREIGN KEY (AttachmentId)
		REFERENCES Attachment(Id)
			ON DELETE CASCADE
           	 		ON UPDATE CASCADE
);

CREATE TABLE AspectRatios (
	Width FLOAT,
    Height FLOAT,
    AspectRatio FLOAT,
    PRIMARY KEY (Width, Height)
);

CREATE TABLE Photo (
	AttachmentID INTEGER PRIMARY KEY,
	URL VARCHAR(320) UNIQUE NOT NULL,
    Latitude FLOAT,
    Longitude FLOAT,
    Width FLOAT,
    Height FLOAT,
    FOREIGN KEY (AttachmentId)
		REFERENCES Attachment(Id)
			ON DELETE CASCADE
			ON UPDATE CASCADE,
	FOREIGN KEY (Latitude, Longitude)
		REFERENCES Location(Latitude, Longitude)
			ON DELETE SET NULL
			ON UPDATE CASCADE,
	FOREIGN KEY (Width, Height)
		REFERENCES AspectRatios(Width, Height)
			ON DELETE SET NULL
            ON UPDATE CASCADE
);

CREATE TABLE Post (
	ID INTEGER PRIMARY KEY,
    	CreatorUsername VARCHAR(50) NOT NULL,
    	AttachmentID INTEGER NOT NULL,
    	Timestamp DATETIME,
    	Slug VARCHAR(100) UNIQUE,
    	Title VARCHAR(100),
    	Text VARCHAR(320),
    	ThemeName VARCHAR(50),
    	FOREIGN KEY (CreatorUsername)
		REFERENCES Account(Username)
			ON DELETE CASCADE
           	 		ON UPDATE CASCADE,
	FOREIGN KEY (AttachmentId)
		REFERENCES Attachment(Id)
			ON DELETE CASCADE
            		ON UPDATE CASCADE,
	FOREIGN KEY (ThemeName)
		REFERENCES Theme(Name)
			ON DELETE SET NULL
            		ON UPDATE CASCADE
);

CREATE TABLE CommentWrite (
	CommentId Integer,
    	PostId INTEGER,
    	Timestamp DATETIME,
    	Text VARCHAR(350),
    	SubmitterUsername VARCHAR(50),
    	PRIMARY KEY (CommentId, PostId),
    	FOREIGN KEY (PostId)
		REFERENCES Post(Id)
			ON DELETE CASCADE
            ON UPDATE CASCADE,
	FOREIGN KEY (SubmitterUsername)
		REFERENCES Account(Username)
			ON DELETE SET NULL
            ON UPDATE CASCADE
);

CREATE TABLE ShareLink (
	URL VARCHAR(320) PRIMARY KEY,
    	Description VARCHAR(320),
    	CreatorUsername VARCHAR(50),
    	PostId Integer,
    	FOREIGN KEY (CreatorUsername)
		REFERENCES Account(Username)
			ON DELETE CASCADE
            		ON UPDATE CASCADE,
	FOREIGN KEY (PostId)
		REFERENCES Post(Id)
			ON DELETE CASCADE
            		ON UPDATE CASCADE
);

CREATE TABLE AttachmentTag (
	AttachmentId INTEGER,
    	TagName VARCHAR(50),
    	PRIMARY KEY (AttachmentId, TagName),
   	FOREIGN KEY (AttachmentId)
		REFERENCES Attachment(Id)
			ON DELETE CASCADE
            		ON UPDATE CASCADE,
	FOREIGN KEY (TagName)
		REFERENCES Tag(Name)
			ON DELETE CASCADE
            		ON UPDATE CASCADE
);

CREATE TABLE BelongsTo (
	PhotoId INTEGER,
    	AlbumId INTEGER,
    	TimeAdded DATETIME,
    	PRIMARY KEY (PhotoId, AlbumId),
    	FOREIGN KEY (PhotoId)
		REFERENCES Attachment(Id)
			ON DELETE CASCADE
            	ON UPDATE CASCADE,
		FOREIGN KEY (AlbumId)
		REFERENCES Attachment(Id)
			ON DELETE CASCADE
            		ON UPDATE CASCADE
);
