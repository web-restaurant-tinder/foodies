export default (state = [], action) => {
    switch(action.type) {
        case "GET_RESTAURANTS_BY_DISTANCE":
            return action.payload;
        default:
            return state;
    }
}