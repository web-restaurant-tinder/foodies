import {httpConfig} from "../utils/http-config";


export const getSwipesByProfileId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/swipe/?swipeProfileId=${id}`);
	dispatch({type: "GET_SWIPES_BY_PROFILE_ID", payload: data })
};