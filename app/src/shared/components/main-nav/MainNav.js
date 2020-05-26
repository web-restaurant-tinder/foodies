import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap"
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SigninModal";
import {Button} from "react-bootstrap";



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
			</Nav>
		</Navbar>
	)
};