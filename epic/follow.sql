use fgallegos59;
DROP TABLE IF EXISTS followFollowedProfileId;
DROP TABLE IF EXISTS followProfileId;
DROP TABLE IF EXISTS followDat;

CREATE TABLE follow(
  followFollowedProfileId BINARY(16) NOT NULL,
  followProfileId BINARY(16) NOT NULL,
  followDate DATETIME(6) NOT NULL
);