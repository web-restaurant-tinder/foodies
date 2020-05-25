import React, {useEffect} from "react"
import {useDispatch, useSelector} from "react-redux";
import {getSwipesBySwipeProfileId} from "../../shared/actions/get-swipes-profile";

export const Home = () => {

    const swipes = useSelector(state => state.swipes);

    const dispatch = useDispatch();

    const effects = () => {
        dispatch(getSwipesBySwipeProfileId)
    };

    const inputs = [];
    useEffect(effects, inputs);

    return (
        <>
            <h1>Home</h1>
        </>
    )
}