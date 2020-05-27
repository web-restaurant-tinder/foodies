import {combineReducers} from "redux"
import restaurantReducer from "./restaurant-reducer"
import swipeReducer from "./swipe-reducer"
import followReducer from "./follow-reducer";

export default combineReducers({
	follows: followReducer,
	restaurants: restaurantReducer,
	swipes : swipeReducer,
})