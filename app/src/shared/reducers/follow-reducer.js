export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_FOLLOWS":
			return action.payload;
		case "GET_FOLLOW_BY_PROFILE_ID":
			return [...state, action.payload];
		default:
			return state;
	}
}
