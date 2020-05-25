export default (state = [], action) => {
    if (action.type === "GET_SWIPES_BY_SWIPE_PROFILE_ID") {
        return [...state, action.payload];
    }
}