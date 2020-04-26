USE srendon4;
ALTER DATABASE srendon4 CHARACTER SET utf8 COLLATE utf8_unicode_ci;
DROP TABLE IF EXISTS Swipe;

CREATE TABLE Swipe(
swipeProfileId BINARY(16) NOT NULL,
swipeRestaurantId CHAR(32),
swipeDate VARCHAR (128),
swipeRight VARCHAR (128) NOT NULL,
FOREIGN KEY(swipeProfileId) REFERENCES swipe(swipeId),
FOREIGN KEY(swipeRestaurantId) REFERENCES swipe(swipeId),
);