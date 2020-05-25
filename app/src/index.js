import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {Home} from "./pages/Home";
import {Followers} from "./pages/Followers";
import Navbar from "react-bootstrap/Navbar";
import {LinkContainer} from "react-router-bootstrap";
import Nav from "react-bootstrap/Nav";


const Routing = () => (
	<>
		<BrowserRouter>
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
				</Nav>
			</Navbar>
			<Switch>
				<Route exact path="/" component={Home}/>
				<Route exact path="/followers/" component={Followers}/>
				<Route component={FourOhFour}/>
			</Switch>
		</BrowserRouter>
	</>
);


ReactDOM.render(<Routing/>, document.querySelector('#root'));