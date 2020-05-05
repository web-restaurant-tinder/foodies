CREATE TABLE IF NOT EXISTS swipe(
swipeProfileId BINARY(128) NOT NULL,
swipeRestaurantId CHAR(32),
swipeDate DATETIME(6),
swipeRight BOOLEAN (128) NOT NULL,
swipeLeft BOOLEAN(128) NOT NULL,
FOREIGN KEY(swipeProfileId) REFERENCES swipe(swipeId),
FOREIGN KEY(swipeRestaurantId) REFERENCES swipe(swipeId),
);
