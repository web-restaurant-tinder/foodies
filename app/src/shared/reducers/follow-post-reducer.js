export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_FOLLOWS":
			return action.payload;
		case "GET_FOLLOW_POSTS":
			return action.payload;
		default:
			return state;
	}
}