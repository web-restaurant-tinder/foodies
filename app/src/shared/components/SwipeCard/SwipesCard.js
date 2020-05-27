import React, {useEffect} from "react";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import * as jwtDecode from "jwt-decode";

export const SwipeCard = ({swipes, restaurants}) => {

    let swipe = swipes [Math.round (Math.random()*swipes.length-1)]
    const submit = () => {
        window.location.reload()
    }
    const currentUserId = (window.localStorage.getItem("jwt-token")) ? (jwtDecode(window.localStorage.getItem
    ("jwt-token")).auth.profileId) : "";





    return (
        <Card style={{ width: '18rem' }}>
            <Card.Img variant="top" src="holder.js/100px180" />
            <Card.Body>
                <Card.Title>Likes</Card.Title>
                <Card.Text>
                    Some quick example text to build on the card title and make up the bulk of
                    the card's content.
                </Card.Text>
                <Button variant="primary">Go somewhere</Button>
            </Card.Body>
        </Card>
    )

};