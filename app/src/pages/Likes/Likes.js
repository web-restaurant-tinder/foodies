import React, {useEffect} from "react"
import {useSelector, useDispatch} from "react-redux";
import Jumbotron from "react-bootstrap/Jumbotron";
import Container from "react-bootstrap/Container";


export const Swipes = () => {

    return (
        <Jumbotron fluid>
            <Container>
                <h1>Your Likes</h1>
                <p>
                    This is a modified jumbotron that occupies the entire horizontal space of
                    its parent.
                </p>
            </Container>
        </Jumbotron>
    );

}
