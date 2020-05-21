import React, {useEffect} from "react"
import {Jumbo} from "../shared/components/Jumbo";
import {Choices} from "../shared/components/Choices";
import {BrowserRouter} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {getRestaurantsByDistance} from "../shared/actions/get-restaurants-distance";

export const Home = () => {

	// find out where user is
	let userLat = 35.087739;
	let userLng = -106.664512;

	navigator.geolocation.getCurrentPosition((data)=> {
		userLat = data.coords.latitude;
		userLng = data.coords.longitude;
	},(message)=>console.log(message));


	// use selector to set users to users stored in state
	const restaurants = useSelector(state => state.restaurants ? state.restaurants : []);

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	// get users
	const effects = () => {
		dispatch(getRestaurantsByDistance(userLat, userLng, 3))
	};

	// set inputs to an empty array before update
	const inputs = [];

	// do this effect on component update
	useEffect(effects, inputs);

console.log(restaurants);


	return (
		<>
			<Jumbo/>
			<Choices/>
			<h1>
				Home
			</h1>
		</>
	)
}