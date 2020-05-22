import React, {useEffect} from "react"
import {Jumbo} from "../../shared/components/Jumbo";
import {Choices} from "../../shared/components/Choices";
import {BrowserRouter} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {getRestaurantsByDistance} from "../../shared/actions/get-restaurants";
import {RestaurantList} from "./RestaurantList";

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



// 	function shuffle(array) {
// 		var currentIndex = array.length, temporaryValue, randomIndex;
//
// 		// While there remain elements to shuffle...
// 		while (0 !== currentIndex) {
//
// 			// Pick a remaining element...
// 			randomIndex = Math.floor(Math.random() * currentIndex);
// 			currentIndex -= 1;
//
// 			// And swap it with the current element.
// 			temporaryValue = array[currentIndex];
// 			array[currentIndex] = array[randomIndex];
// 			array[randomIndex] = temporaryValue;
// 		}
//
// 		return array;
// 	}
//
//
//
// console.log(restaurants);
// if (restaurants.length !== 0){
//
// // Used like so
// 	let shuffledRestaurants = shuffle(restaurants);
// 	console.log(shuffledRestaurants);
// }

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







// 	return (
// 		<main className="container">
// 			<table className="table table-responsive table-hover table-dark">
// 				<thead>
// 				<tr>
// 					<th><h4>Restaurant Id</h4></th>
// 					<th><h4>Name</h4></th>
// 					<th><h4>Star Rating</h4></th>
// 					<th><h4>Phone</h4></th>
// 					<th><h4>Address</h4></th>
// 					<th><h4>Url</h4></th>
// 				</tr>
// 				</thead>
// 				<RestaurantList restaurants={restaurants}/>
// 			</table>
// 		</main>
// 	)
};