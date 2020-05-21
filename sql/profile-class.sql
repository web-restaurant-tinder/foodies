USE cap28_rtinder;
ALTER DATABASE cap28_rtinder CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS follow;
DROP TABLE IF EXISTS profile;

CREATE TABLE IF NOT EXISTS profile(
   profileActivationToken CHAR(32),
	profileAvatarCloudinaryId CHAR(32),
	profileAvatarUrl VARCHAR(255),
	profileEmail VARCHAR(128) NOT NULL,
	profileFirstName VARCHAR(32) NOT NULL,
	profileHash CHAR(97) NOT NULL,
	profileId BINARY(16) NOT NULL,
	profileLastName VARCHAR(32) NOT NULL,
	profileUserName VARCHAR(32) NOT NULL,
	UNIQUE (profileEmail),
	UNIQUE (profileUserName),
	PRIMARY KEY (profileId)
);