import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {Navigation} from "./shared/components/Navigation";
import {Home} from "./pages/Home";
// import {Test2} from "./pages/Test2";
import {Jumbo} from "./shared/components/Jumbo"
import {Choices} from "./shared/components/Choices";
// import "app/src/pages/mystylesheet.css"

const Routing = () => (
	<>
		<Navigation/>
		<Jumbo/>
		<Choices/>
		<BrowserRouter>
			<Switch>
				<Route exact path="/" component={Home}/>
				{/*<Route exact path="/test2" component={Test2}/>*/}
				<Route component={FourOhFour}/>
			</Switch>
		</BrowserRouter>

	</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));