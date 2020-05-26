import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap"
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SigninModal";
import {Button} from "react-bootstrap";
import FormControl from "react-bootstrap/FormControl";
import Form from "react-bootstrap/Form";
import Row from "react-bootstrap/Row";
export const MainNav = (props) => {
    return(
        <Navbar bg="dark" variant="dark">
            <LinkContainer exact to="/" >
                <Navbar.Brand>You Pick</Navbar.Brand>
            </LinkContainer>
            <Nav className="mr-auto">
                <LinkContainer exact to="/followers">
                    <Button variant="dark">
                        Followers
                    </Button>
                </LinkContainer>
                <LinkContainer exact to="/likes">
                    <Button variant="dark">
                        Likes
                    </Button>
                </LinkContainer>
                <SignUpModal/>
                <SignInModal/>
                <Row>
                    <Form inline id ='NavForm'>
                        <FormControl type="text" placeholder="Search"/>
                        <Button variant="outline-warning">Search</Button>
                    </Form>
                </Row>
            </Nav>
        </Navbar>
    )
};