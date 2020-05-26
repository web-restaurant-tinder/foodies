import React, {useEffect} from "react"
import {Followers} from "../../shared/components/Follow-Card";
import {useDispatch, useSelector} from "react-redux";
import {getFollowByCurrentLoggedInUser} from "../../shared/actions/get-follow";

export const Follow = () => {
// use selector to set follows to follows stored in state
	const follows = useSelector(state => state.follows);

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	// get follows
	const effects = () => {
		dispatch(getFollowByCurrentLoggedInUser())
	};

	// set inputs to an empty array before update
	const inputs = [];

	// do this effect on component update
	useEffect(effects, inputs);
	return (
		<>
			<Followers follows={follows}/>
		</>
	)
}
