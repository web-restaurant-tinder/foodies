import React from "react";
import Container from "react-bootstrap/Container";
import {Card} from "react-bootstrap";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faHeart, faThumbsDown} from "@fortawesome/free-solid-svg-icons";
import {httpConfig} from "../utils/http-config";
import * as jwtDecode from "jwt-decode"
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import {getAllSwipes} from "../actions/get-swipes";
import {removeRestaurantByRestaurantId} from "../actions/get-restaurants";
import {useDispatch} from "react-redux";




export const Restaurant = ({restaurants, swipes}) => {

	const dispatch = useDispatch()
	const currentUserId = (window.localStorage.getItem("jwt-token")) ? (jwtDecode(window.localStorage.getItem("jwt-token")).auth.profileId) : "";
	const filteredSwipes = swipes.filter(swipe => swipe.swipeProfileId = currentUserId);
	let filteredRestaurants = [];
	restaurants.forEach(restaurant => {
		if(swipes.length) {
			filteredSwipes.forEach(filteredSwipe => {
				filteredRestaurants = filteredSwipe.swipeRestaurantId !== restaurant.restaurantId ? [...filteredRestaurants, restaurant] : filteredRestaurants
			})
		} else {
			filteredRestaurants = [...filteredRestaurants, restaurant]
		}
	});
	filteredRestaurants = (window.localStorage.getItem("jwt-token")) ? filteredRestaurants : restaurants

	let index = Math.round(Math.random() * filteredRestaurants.length - 1);
	index = index < 0 ? 0 : index;
	let restaurant = filteredRestaurants [index];

	const handleSwipe = (swipeValue) => {
		httpConfig.post("/apis/swipe/", {"swipeRestaurantId": restaurant.restaurantId, "swipeRight": swipeValue})
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200) {
					dispatch(removeRestaurantByRestaurantId(restaurant.restaurantId))
				}
			})
	}

	const swipeRight = () => {
		handleSwipe(1)
	};

	const swipeLeft = () => {
		handleSwipe(0)
	};

	return (
		<>
			<Container style={{display: "center", margin: "auto", width: "62%"}}>

				<Card className="text-center" bg={"dark"} text={'white'}>
					<Card.Header>{restaurant.restaurantName}</Card.Header>
					{restaurant && (
						<>
							<Card.Img variant="top" src={restaurant.restaurantAvatar}/>
							<Row>
								<Col xs={6}>
									<button type="button" onClick={swipeLeft} className="btn btn-warning btn-circle btn-xl">
										<FontAwesomeIcon size="lg"
															  icon={faHeart}/>
									</button>
								</Col>
								<Col xs={6}>
									<button type="button" onClick={swipeRight} className="btn btn-warning btn-circle btn-xl">
										<FontAwesomeIcon size="lg" icon={faThumbsDown}/>
									</button>
								</Col>
							</Row>
							<Card.Body>
								<p>Address- {restaurant.restaurantAddress}</p>

								<p>Phone- {restaurant.restaurantPhone}</p>

								<p>Category- {restaurant.restaurantFoodType}</p>

								<p><a href={restaurant.restaurantUrl}>Yelp- {restaurant.restaurantName}</a></p>

								<p>Rating- {restaurant.restaurantStarRating}</p>
							</Card.Body>
						</>)}
				</Card>

			</Container>

		</>
	)
};