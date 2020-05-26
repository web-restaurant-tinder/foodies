import {combineReducers} from "redux"
import followReducer from "./follow-reducer";

export default combineReducers({
	follows: followReducer,
})