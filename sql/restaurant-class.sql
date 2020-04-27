CREATE TABLE restaurant(
	restaurantId BINARY(16) not null,
	restaurantAddress VARCHAR(32),
	restaurantAvatar VARCHAR(32),
	restaurantFoodType VARCHAR(75) NOT NULL,
	restaurantLat FLOAT(10, 6) NOT NULL,
	restaurantLng FLOAT(10, 6) NOT NULL,
	restaurantName VARCHAR(32) NOT NULL,
	restaurantPhone VARCHAR(15) NOT NULL,
	restaurantStarRating ENUM ('1','2','3','4','5'),
	restaurantUrl VARCHAR(75),
	PRIMARY KEY (restaurantId),
	UNIQUE (restaurantLat),
	UNIQUE (restaurantLng),
	UNIQUE (restaurantPhone),
	UNIQUE (restaurantUrl)
);