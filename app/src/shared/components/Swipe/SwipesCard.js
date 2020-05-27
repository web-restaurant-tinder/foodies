import React, {useEffect} from "react";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import * as jwtDecode from "jwt-decode";

export const SwipeCard = ({swipes, restaurant}) => {

    // let swipe = swipes [Math.round (Math.random()*swipes.length-1)]
    // const submit = () => {
    //     window.location.reload()
    // }
    // const currentUserId = (window.localStorage.getItem("jwt-token")) ? (jwtDecode(window.localStorage.getItem
    // ("jwt-token")).auth.profileId) : "";





    return (
        <>

            <h1 className="text-center bg-dark text-white">{restaurant.restaurantTitle}</h1>
            <Card style={{width: '50rem'}}>
                <Card.Img variant="top" src={restaurant.restaurantImageUrl} />
                <Card.Body>
                    <Card.Link href={restaurant.restaurantLink} target="_blank">Click For Restaurant Info</Card.Link>
                    <Button variant="primary">
                        Delete
                    </Button>
                </Card.Body>
            </Card>

        </>
    )

};