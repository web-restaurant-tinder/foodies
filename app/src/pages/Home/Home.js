import React, {useEffect, useState} from "react"
import {useDispatch, useSelector} from "react-redux";
import {getRestaurantsByDistance} from "../../shared/actions/get-restaurants";
import {Restaurant} from "../../shared/components/Restaurant";
import {getAllSwipes} from "../../shared/actions/get-swipes";

export const Home = () => {

	// find out where user is
	let userLat = 35.087739;
	let userLng = -106.664512;
	let distance = 10;

	// use selector to set users to users stored in state
	const restaurants = useSelector(state => state.restaurants ? state.restaurants : []);
	const swipes = useSelector(state => state.swipes ? state.swipes : []);
	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	const effects = () => {
	dispatch(getAllSwipes())
		navigator.geolocation.getCurrentPosition((data)=> {
			userLat = data.coords.latitude;
			userLng = data.coords.longitude;
			dispatch(getRestaurantsByDistance(userLat, userLng, distance))
		},(message)=>{
			dispatch(getRestaurantsByDistance(userLat, userLng, distance))
			});
	};

	// set inputs to an empty array before update
	const inputs = [];

	// do this effect on component update
	useEffect(effects, inputs);

	return (
		<>
			{restaurants.length && swipes.length ? <Restaurant restaurants={restaurants} swipes={swipes} effects = {effects}/> : ""}
		</>
	)
};