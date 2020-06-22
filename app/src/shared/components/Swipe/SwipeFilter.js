// import React, {useEffect} from 'react'
// import Jumbotron from "react-bootstrap/Jumbotron";
// import {useDispatch, useSelector} from "react-redux";
// import {getSwipesByCurrentLoggedInUser} from "../../actions/get-swipes1";
// import {filterRestaurantsBySwipes} from "../../actions/filter-restaurants";
// import {SwipeCard} from "./SwipesCard";
//
// export const SwipeFilter = ({swipes}) => {
//
//     // use selector to set favorites to users stored in state
//     const activities = useSelector(state => state.restaurant ? state.restaurant : []);
//
//     // use dispatch from redux to dispatch actions
//     const dispatch = useDispatch();
//
//     // get favorites
//     const effects = () => {
//
//
//         dispatch(filterRestaurantsBySwipes(restaurant))
//     };
//
//     // set inputs to an empty array before update
//     const inputs = [];
//
//     // do this effect on component update
//     useEffect(effects, inputs);
//
//     return (
//         <>
//             <Jumbotron fluid>
//                 <h1 className="text-center">Favorites</h1>
//             </Jumbotron>
//
//             <main>
//                 <div className="card-group card-columns">
//                     {restaurant.map(restaurant => <SwipeCard restaurant={restaurant} key={restaurant.restaurantId}/>)}
//                 </div>
//             </main>
//
//
//         </>
//     )
// }