import {httpConfig} from "../utils/http-config";

export const getFollow = () => async dispatch => {
	const {data} = await httpConfig('/apis/users/');
	dispatch({type: "GET_ALL_FOLLOWS", payload: data })
};

export const getFollowByFollowProfileId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/followers/${id}`);
	dispatch({type: "GET_FOLLOW_BY_FOLLOW_ID", payload: data })
};