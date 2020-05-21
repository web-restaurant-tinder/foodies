import {httpConfig} from "../utils/http-config";

export const getAllSwipes = () => async (dispatch) => {
    const payload =  await httpConfig.get("/apis/swipe/");
    dispatch({type: "GET_ALL_SWIPES",payload : payload.data });
};