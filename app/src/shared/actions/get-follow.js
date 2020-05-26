import {httpConfig} from "../utils/http-config";

export const getFollowByCurrentLoggedInUser = () => async dispatch => {
	const {data} = await httpConfig.get(`/apis/follow/`);
	dispatch({type: "GET_FOLLOW_BY_CURRENT_LOGGED_IN_USER", payload: data })
};