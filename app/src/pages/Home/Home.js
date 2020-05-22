import React, {useEffect} from "react"
import {Jumbo} from "../../shared/components/Jumbo";
import {BrowserRouter} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {getRestaurantsByDistance} from "../../shared/actions/get-restaurants";
import {RestaurantList} from "./RestaurantList";
import {Restaurant} from "../../shared/components/Restaurant";

export const Home = () => {

	// find out where user is
	let userLat = 35.087739;
	let userLng = -106.664512;
	let distance = 5;

	// use selector to set users to users stored in state
	const restaurants = useSelector(state => state.restaurants ? state.restaurants : []);

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();
console.log(userLat, userLng)
	// get users
	const effects = () => {
		navigator.geolocation.getCurrentPosition((data)=> {
			userLat = data.coords.latitude;
			userLng = data.coords.longitude;
			dispatch(getRestaurantsByDistance(userLat, userLng, distance))
		},(message)=>{
			dispatch(getRestaurantsByDistance(userLat, userLng, distance))
			console.log(message)});
	};

	// set inputs to an empty array before update
	const inputs = [];

	// do this effect on component update
	useEffect(effects, inputs);


	return (
		<>
			<Jumbo/>
			{restaurants.length && <Restaurant restaurants={restaurants}/>}
		</>
	)
};