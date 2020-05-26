import React from 'react'
import Button from "react-bootstrap/Button";

export default function FollowProfileButton (props) {
	const followClick = () => {
		const headers = {
			'X-JWT-TOKEN': window.localStorage.getItem("jwt-token")
		};
		httpConfig.post("/apis/follow/", values, {
			headers: headers})
			.then(reply => {
				let {message, type} = reply;
				setStatus({message, type});
				if(reply.status === 200) {
					resetForm();
					setStatus({message, type});
					/*TODO: find a better way to re-render the post component!*/
					setTimeout(() => {
						window.location.reload();
					}, 1500);
				}
				// if there's an issue with a $_SESSION mismatch with xsrf or jwt, alert user and do a sign out
				if(reply.status === 401) {
					handleSessionTimeout();
				}
			});
		props.onButtonClick(follow)
	}
	const unfollowClick = () => {
		httpConfig.delete("/api/follow/")
		props.onButtonClick(unfollow)
	}
	return (<div>
		{ props.following
			? (<Button variant="contained" color="secondary" onClick={unfollowClick}>Unfollow</Button>)
			: (<Button variant="contained" color="primary" onClick={followClick}>Follow</Button>)
		}
	</div>)
}
FollowProfileButton.propTypes = {
	following: PropTypes.bool.isRequired,
	onButtonClick: PropTypes.func.isRequired
}