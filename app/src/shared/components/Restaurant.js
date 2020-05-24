import React, {useEffect, useState} from "react";
import Container from "react-bootstrap/Container";
import {Accordion, Card} from "react-bootstrap";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faHeart, faThumbsDown} from "@fortawesome/free-solid-svg-icons";
import {httpConfig} from "../utils/http-config";
import {useDispatch} from "react-redux";
import {getAllSwipes} from "../actions/get-swipes";
import * as jwtDecode from "jwt-decode"


export const Restaurant = ({restaurants, swipes, effects}) => {
	console.log(restaurants);
	console.log(swipes);
	const currentUserId = (window.localStorage.getItem("jwt-token")) ? (jwtDecode(window.localStorage.getItem("jwt-token")).auth.profileId) : ""
	const filteredSwipes = swipes.filter(swipe => swipe.swipeProfileId = currentUserId)

	let filteredRestaurants = []
restaurants.forEach(restaurant => {
	if (swipes.length){
	filteredSwipes.forEach(filteredSwipe => {
		filteredRestaurants = filteredSwipe.swipeRestaurantId !== restaurant.restaurantId ? [...filteredRestaurants, restaurant] : filteredRestaurants
	})
}else {
		filteredRestaurants = [...filteredRestaurants, restaurant]
	}
})
console.log(filteredRestaurants);





	let index = Math.round(Math.random() * filteredRestaurants.length - 1)
	index = index < 0 ? 0 : index
	console.log(index);
	let restaurant = filteredRestaurants [index]
	// const dispatch = useDispatch();
// console.log(restaurant);
	const swipeRight = () => {
		httpConfig.post("/apis/swipe/", {"swipeRestaurantId": restaurant.restaurantId, "swipeRight": 1})
			.then(reply => {
				let {message, type} = reply;
				if(reply.status === 200 && reply.headers["x-jwt-token"]) {
					window.localStorage.removeItem("jwt-token");
					window.localStorage.setItem("jwt-token", reply.headers["x-jwt-token"]);
					// dispatch(getAllSwipes())
				}
			})
	};


	return (
		<>
			<Container style={{display: "block", margin: "auto", width: "62%"}}>
				<Accordion>
					<Card className="text-center" bg={"warning"}>
						<Card.Header>{restaurant.restaurantName}</Card.Header>
						{restaurant && (
							<>
						<Accordion.Toggle as={Card.Header} eventKey="1">
							<Card.Img variant="top" src={restaurant.restaurantAvatar}/>
						</Accordion.Toggle>

						<Card.Text>
							{restaurant.restaurantAddress}
							<br/>
							{restaurant.restaurantPhone}
							<br/>
							{restaurant.restaurantFoodType}
							<br/>
							<a href={restaurant.restaurantUrl}>{restaurant.restaurantName}-yelp</a>
							<br/>
							{restaurant.restaurantStarRating}

						</Card.Text>

						<button type="button" className="btn btn-danger btn-circle btn-xl"><FontAwesomeIcon size="lg"
																																		icon={faHeart}/>
						</button>
						<button type="button" onClick={swipeRight} className="btn btn-danger btn-circle btn-xl">
							<FontAwesomeIcon size="lg" icon={faThumbsDown}/>
						</button>
							</> )}
					</Card>
				</Accordion>
			</Container>

		</>
	)
};