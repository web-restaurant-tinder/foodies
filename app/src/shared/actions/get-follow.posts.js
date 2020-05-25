import {httpConfig} from "../utils/http-config";
import _ from "lodash";
import {getFollowByFollowProfileId} from "./get-follow";

export const getAllPosts = () => async dispatch => {
	const {data} = await httpConfig(`/apis/users/?posts=true`);
	dispatch({type: "GET_ALL_POSTS", payload: data})
};

export const getFollowPosts = (userId) => async dispatch => {
	const {data} = await httpConfig(`/apis/users/?postFollowProfileId=${followProfileId}`);
	dispatch({type: "GET_FOLLOW_POSTS", payload: data})
};


export const getPostsAndFollow = () => async (dispatch, getState) => {

	await dispatch(getAllPosts());
	//commented out lines below are equivalent to the _ chain method


	const followIds = _.unique(_.map(getState().posts, "followProfileId"));
	followIds.forEach(id => dispatch(getFollowByFollowProfileId(id)));

	// _.chain(getState().posts)
	// 	.map("postUserId")
	// 	.uniq()
	// 	.forEach(id => dispatch(getUserByUserId(id)))
	// 	.value()
};