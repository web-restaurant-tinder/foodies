export default (state = [], action) => {
    switch(action.type) {
        case "GET_SWIPES_BY_CURRENT_LOGGED_IN_USER":
            return [...state, action.payload];
        default:
            return state;
    }
}