export default (state = [], action) => {
	switch(action.type) {
		case "GET_PROFILE_BY_USERNAME":
			return action.payload;
		default:
			return state;
	}
}