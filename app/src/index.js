import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter, Route, Switch} from "react-router-dom";
import {FourOhFour} from "./pages/FourOhFour/FourOhFour";
import {MainNav} from "./shared/components/MainNav";
import {Follow} from "./pages/Follow/Follow";
// import {Test2} from "./pages/Test2";
import {applyMiddleware, createStore} from "redux";
import thunk from "redux-thunk";
import reducers from "./shared/reducers"
import {Provider} from "react-redux";
import {Jumbo} from "./shared/components/Jumbo";



const store = createStore(reducers,applyMiddleware(thunk));
const Routing = (store) => (
	<>
		<Provider store={store}>
			<BrowserRouter>
				<MainNav/>
				<Jumbo/>
				<Switch>
					<Route exact path="/" component={Follow}/>
					{/*<Route exact path="/test2" component={Test2}/>*/}
					<Route component={FourOhFour}/>
				</Switch>
			</BrowserRouter>
		</Provider>
	</>
);
ReactDOM.render(Routing(store) , document.querySelector("#root"));