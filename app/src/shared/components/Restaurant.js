import React from "react";
import Container from "react-bootstrap/Container";
import {Card} from "react-bootstrap";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faHeart, faThumbsDown} from "@fortawesome/free-solid-svg-icons";
import {httpConfig} from "../utils/http-config";
import * as jwtDecode from "jwt-decode"
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";


export const Restaurant = ({restaurants, swipes}) => {
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


	let index = Math.round(Math.random() * filteredRestaurants.length - 1);
	index = index < 0 ? 0 : index;
	let restaurant = filteredRestaurants [index];


	const swipeRight = () => {
		httpConfig.post("/apis/swipe/", {"swipeRestaurantId": restaurant.restaurantId, "swipeRight": 1})
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200 && reply.headers["x-jwt-token"]) {
					window.localStorage.removeItem("jwt-token");
					window.localStorage.setItem("jwt-token", reply.headers["x-jwt-token"]);
				}
			})
	};


	const swipeLeft = () => {
		httpConfig.post("/apis/swipe/", {"swipeRestaurantId": restaurant.restaurantId, "swipeRight": 0})
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200 && reply.headers["x-jwt-token"]) {
					window.localStorage.removeItem("jwt-token");
					window.localStorage.setItem("jwt-token", reply.headers["x-jwt-token"]);
				}
			})
	};


	return (
		<>
			<Container style={{display: "block", margin: "auto", width: "62%"}}>

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
							<Card.Text>
								<p>Address- {restaurant.restaurantAddress}</p>

								<p>Phone- {restaurant.restaurantPhone}</p>

								<p>Category- {restaurant.restaurantFoodType}</p>

								<p><a href={restaurant.restaurantUrl}>Yelp- {restaurant.restaurantName}</a></p>

								<p>Rating- {restaurant.restaurantStarRating}</p>
							</Card.Text>
						</>)}
				</Card>

			</Container>

		</>
	)
};