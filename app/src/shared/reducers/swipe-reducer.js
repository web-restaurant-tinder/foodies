export default (state = [], action) => {
	switch(action.type) {
		case "GET_SWIPES_BY_PROFILE_ID":
			return [...state, action.payload];
		case "GET_ALL_SWIPES":
			return action.payload;
		case "GET_SWIPE_BY_SWIPE_PROFILE_ID_AND_SWIPE_RESTAURANT_ID":
			return action.payload;
		default:
			return state;
	}
}