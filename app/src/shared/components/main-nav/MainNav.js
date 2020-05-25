import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap"
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModal";

export const MainNav = (props) => {
    return(
        <Navbar bg="primary" variant="dark">
            <LinkContainer exact to="/" >
                <Navbar.Brand>Home</Navbar.Brand>
            </LinkContainer>
            <Nav className="mr-auto">
                <LinkContainer exact to="/followers">
                    <Nav.Link>Followers</Nav.Link>
                </LinkContainer>
                <LinkContainer exact to="/likes"
                ><Nav.Link>Likes</Nav.Link>
                </LinkContainer>
                <SignUpModal/>
                <SignInModal/>
            </Nav>
        </Navbar>
    )
};