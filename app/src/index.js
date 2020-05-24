import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter, Route, Switch} from "react-router-dom";
import {FourOhFour} from "./pages/FourOhFour/FourOhFour";
import {MainNav} from "./shared/components/main-nav/MainNav";
import {Home} from "./pages/Home/Home";
import "./index.css"
import {applyMiddleware, createStore} from "redux";
import thunk from "redux-thunk";
import reducers from "./shared/reducers"
import {Provider} from "react-redux";


const store = createStore(reducers,applyMiddleware(thunk));

const Routing = (store) => (
    <>
        <Provider store={store}>
            <BrowserRouter>
                <MainNav/>
                <Switch>
                    <Route exact path="/" component={Home}/>
                    {/*<Route exact path="/test2" component={Test2}/>*/}
                    <Route component={FourOhFour}/>
                </Switch>
            </BrowserRouter>
        </Provider>

    </>
);
ReactDOM.render(Routing(store) , document.querySelector("#root"));