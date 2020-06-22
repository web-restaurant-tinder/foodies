import {httpConfig} from "../utils/http-config";

export const getProfileByProfileUserName = () => async dispatch => {
	const {data} = await httpConfig('/apis/swipe/');
	dispatch({type: "GET_PROFILE_BY_USERNAME", payload: data })
};
