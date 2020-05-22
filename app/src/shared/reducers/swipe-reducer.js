export default (state = [], action) => {
    switch(action.type) {
        case "GET_SWIPES_BY_PROFILE_ID":
            return [...state, action.payload];
        default:
            return state;
    }
}