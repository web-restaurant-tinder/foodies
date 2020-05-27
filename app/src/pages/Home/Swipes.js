import React, {useEffect} from "react"
import {useSelector, useDispatch} from "react-redux";
import {SwipeCard} from "../../shared/components/SwipeCard/SwipesCard";
import {getSwipesByCurrentLoggedInUser} from "../../shared/actions/get-swipes";


export const Swipes = () => {

    const restaurants = useSelector(state => state.restaurants ? state.restaurants : []);
    const swipes = useSelector(state => state.swipes ? state.swipes : []);    console.log(swipes)
    const dispatch = useDispatch();

    //get swipes
    const effects = () => {
      dispatch(getSwipesByCurrentLoggedInUser())
    };

    const inputs = [];

    useEffect(effects, inputs);

    return (
        <>
            {swipes.length && <SwipeCard swipes = {swipes}/>}
        </>
    );


}
