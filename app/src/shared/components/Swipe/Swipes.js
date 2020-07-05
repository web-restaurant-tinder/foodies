import React, {useEffect} from "react"
import {useSelector, useDispatch} from "react-redux";
import {SwipeCard} from "./SwipesCard";
import {getAllSwipes, getSwipesByProfileId} from "../../actions/get-swipes";
import * as jwtDecode from "jwt-decode";
import {getRestaurantsByDistance} from "../../actions/get-restaurants";


export const Swipes = (props) => {

    let userLat = 35.087739;
    let userLng = -106.664512;
    let distance = 10;

    // use selector to set users to users stored in state
    const restaurants = useSelector(state => state.restaurants ? state.restaurants : []);
    const swipes = useSelector(state => state.swipes ? state.swipes : []);
    // use dispatch from redux to dispatch actions
    const dispatch = useDispatch();
    const currentUserId = (window.localStorage.getItem("jwt-token")) ? (jwtDecode(window.localStorage.getItem("jwt-token")).auth.profileId) : "";

    const effects = () => {
        dispatch(getSwipesByProfileId(currentUserId))
        navigator.geolocation.getCurrentPosition((data)=> {
            userLat = data.coords.latitude;
            userLng = data.coords.longitude;
            dispatch(getRestaurantsByDistance(userLat, userLng, distance))
        },(message)=>{
            dispatch(getRestaurantsByDistance(userLat, userLng, distance))
        });
    };

    //
    let filteredRestaurants = [];
    restaurants.forEach(restaurant => {
        if(swipes.length) {
            swipes.forEach(filteredSwipe => {
                filteredRestaurants = filteredSwipe.swipeRestaurantId === restaurant.restaurantId ? [...filteredRestaurants, restaurant] : filteredRestaurants
            })
        }

    });
    filteredRestaurants = (window.localStorage.getItem("jwt-token")) ? filteredRestaurants : restaurants

// console.log(filteredRestaurants)
    const inputs = [];

    useEffect(effects, inputs);

    return (
        <>
            {filteredRestaurants.length ? <SwipeCard restaurants={filteredRestaurants}/>: ""}
        </>
    );
};
