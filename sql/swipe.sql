USE cap28_rtinder;
ALTER DATABASE cap28_rtinder CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS swipe(
	swipeProfileId BINARY(16) NOT NULL,
	swipeRestaurantId BINARY(16) NOT NULL,
	swipeDate DATETIME(6),
	swipeRight TINYINT(1) NOT NULL,
	swipeLeft TINYINT(1) NOT NULL,
	FOREIGN KEY(swipeProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(swipeRestaurantId) REFERENCES restaurant(restaurantId)
);
