import {httpConfig} from "../utils/http-config";


export const getSwipesByProfileId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/swipe/?swipeProfileId=${id}`);
	dispatch({type: "GET_SWIPES_BY_PROFILE_ID", payload: data })
};

export const getAllSwipes = () => async dispatch => {
	const {data} = await httpConfig('/apis/swipe/');
	dispatch({type: "GET_ALL_SWIPES", payload: data })
};

export const getSwipeBySwipeProfileIdAndSwipeRestaurantId = (swipeProfileId, swipeRestaurantId) => async dispatch => {
	const {data} = await httpConfig.get(`/apis/swipe/?swipeProfileId=${swipeProfileId} &swipeRestaurantId=${swipeRestaurantId}`);
	dispatch({type: "GET_SWIPE_BY_SWIPE_PROFILE_ID_AND_SWIPE_RESTAURANT_ID", payload: data })
};
