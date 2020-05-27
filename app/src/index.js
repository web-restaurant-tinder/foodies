import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter, Route, Switch} from "react-router-dom";
import {FourOhFour} from "./pages/FourOhFour/FourOhFour";
import {MainNav} from "./shared/components/main-nav/MainNav";
import {Home} from "./pages/Home/Home";
// import {Test2} from "./pages/Test2";
import "./index.css"
import {Jumbo} from "./shared/components/Jumbo";
import Provider from "react-redux/lib/components/Provider 2";
import {applyMiddleware, createStore} from "redux";
import thunk from "redux-thunk";
import reducers from "./shared/reducers/";
import {Follow} from "./pages/Follow/Follow";


const store = createStore(reducers,applyMiddleware(thunk));
const Routing = (store) => (
	<>
		<Provider store={store}>
			<BrowserRouter>
				<MainNav/>
				<Jumbo/>
				<Switch>
					<Route exact path="/" component={Home}/>
					<Route exact path="/Follow" component={Follow}/>

					{/*<Route exact path="/test2" component={Test2}/>*/}
					<Route component={FourOhFour}/>
				</Switch>
			</BrowserRouter>
		</Provider>

	</>
);
ReactDOM.render(Routing(store) , document.querySelector("#root"));