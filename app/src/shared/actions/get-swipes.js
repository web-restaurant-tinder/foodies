import {httpConfig} from "../utils/http-config";


export const getSwipesByCurrentLoggedInUser = () => async dispatch => {
    const {data} = await httpConfig.get(`/apis/swipe/`);
    dispatch({type: "GET_SWIPES_BY_CURRENT_LOGGED_IN_USER", payload: data })
};






