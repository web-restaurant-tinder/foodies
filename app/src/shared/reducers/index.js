import {combineReducers} from "redux"
import restaurantReducer from "./restaurant-reducer"
import swipeReducer from "./swipe-reducer"


export default combineReducers({
	restaurants: restaurantReducer,
	swipes : swipeReducer,
})