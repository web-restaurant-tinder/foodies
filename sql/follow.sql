DROP TABLE IF EXISTS follow;

CREATE TABLE follow(
	followFollowedProfileId BINARY(16) NOT NULL,
	followProfileId BINARY(16) NOT NULL,
	followDate DATETIME(6) NOT NULL
);