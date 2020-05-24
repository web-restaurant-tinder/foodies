import React, {useEffect} from "react"
import {useSelector, useDispatch} from "react-redux";
import {BrowserRouter} from "react-router-dom";
import {getSwipesByProfileId} from "../../shared/actions/get-swipes";
import Card from "react-bootstrap/Card";

export const Home = () => {

    const swipes = useSelector(state => state.swipes);
    const dispatch = useDispatch();

    const effects = () => {
        dispatch(getSwipesByProfileId());
    };

    const inputs = [];

    useEffect(effects,inputs);

    return (
        <>
            {swipes.map(swipe => {
                return(
                    <Card style={{ width: '18rem' }} key={swipe.swipeRestaurantId}>
                        <Card.Img variant="top" src={swipe.restaurantAvatar} />
                        <Card.Body>
                            <Card.Text>{swipe.restaurantName}</Card.Text>
                            <Card.Text>{new Date(swipe.swipeDate).toDateString()}</Card.Text>
                        </Card.Body>
                    </Card>)
            })}
        </>


    )
};
