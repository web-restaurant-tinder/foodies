import React, {useEffect} from "react";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import * as jwtDecode from "jwt-decode";

export const SwipeCard = ({restaurants}) => {

    // let swipe = swipes [Math.round (Math.random()*swipes.length-1)]
    // const submit = () => {
    //     window.location.reload()
    // }
    // const currentUserId = (window.localStorage.getItem("jwt-token")) ? (jwtDecode(window.localStorage.getItem
    // ("jwt-token")).auth.profileId) : "";



    return (
        <>
            {restaurants.map( (restaurant, i)=>
                (
                    <Card style={{display: "center", margin: "auto", width: "40%"}} key={i}>
                        <Card.Title className="text-center bg-dark text-white">{restaurant.restaurantName}</Card.Title>

                        <Card.Img variant="top" src={restaurant.restaurantAvatar} />
                    <Card.Body>
                    <Card.Link href={restaurant.restaurantUrl} target="_blank">Click For Restaurant Info</Card.Link>
                    {/*<Button variant="primary">*/}
                    {/*Delete*/}
                    {/*</Button>*/}
                    </Card.Body>
                    </Card>
                )
                ) }
            </>
            )

};