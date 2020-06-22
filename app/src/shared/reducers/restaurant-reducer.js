export default (state = [], action) => {
	switch(action.type) {
		case "GET_RESTAURANTS_BY_DISTANCE":
			return action.payload;
		case "REMOVE_RESTAURANT_BY_RESTAURANT_ID":
			return state.filter(restaurant => restaurant.restaurantId !== action.payload)

		default:
			return state;
	}
}