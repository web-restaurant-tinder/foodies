import {httpConfig} from "/app/src/shared/utils/http-config";

export const getFollowByProfileId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/followers/${id}`);
	dispatch({type: "GET_FOLLOW_BY_PROFILE_ID", payload: data })
};