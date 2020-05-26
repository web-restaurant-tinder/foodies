export default (state = [], action) => {
	switch(action.type) {
		case "GET_FOLLOW_BY_CURRENT_LOGGED_IN_USER":
			return action.payload;
		default:
			return state;
	}
}
