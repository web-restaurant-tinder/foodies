USE cap28_rtinder;
ALTER DATABASE cap28_rtinder CHARACTER SET utf8 COLLATE utf8_unicode_ci;


DROP TABLE IF EXISTS follow;

CREATE TABLE follow(
	followFollowedProfileId BINARY(16) NOT NULL,
	followProfileId BINARY(16) NOT NULL,
	followDate DATETIME(6) NOT NULL,
	FOREIGN KEY (followFollowedProfileId) REFERENCES profile(profileId),
	FOREIGN KEY (followProfileId) REFERENCES profile(profileId),
	PRIMARY KEY (followFollowedProfileId, followProfileId)
);