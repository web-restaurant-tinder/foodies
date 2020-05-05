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