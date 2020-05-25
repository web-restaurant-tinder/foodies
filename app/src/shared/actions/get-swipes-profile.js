import {httpConfig} from "../utils/http-config";


export const getSwipesBySwipeProfileId = (id) => async dispatch => {
    const {data} = await httpConfig.get(`/apis/swipe/?swipeProfileId=${id}`);
    dispatch({type: "GET_SWIPES_BY_SWIPE_PROFILE_ID", payload: data })
};

export const getAllSwipes = () => async dispatch => {
    const {data} = await httpConfig.get(`/apis/swipe/`);
    dispatch({type: "GET_ALL_SWIPES", payload: data })
};





