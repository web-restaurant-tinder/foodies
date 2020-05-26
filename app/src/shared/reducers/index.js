import {combineReducers} from "redux";
import swipeReducer from "./swipe-reducer"

export default combineReducers( {
    swipes : swipeReducer,
})