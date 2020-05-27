import {httpConfig} from "../utils/http-config";

export const getRestaurantsByDistance = (lat, lng, distance) => async dispatch => {
	const {data} = await httpConfig(`/apis/restaurant/?restaurantLat=${lat}&restaurantLng=${lng}&distance=${distance}`);
	dispatch({type: "GET_RESTAURANTS_BY_DISTANCE", payload: data})
};

