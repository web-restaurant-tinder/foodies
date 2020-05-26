import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter, Route, Switch} from "react-router-dom";
import {FourOhFour} from "./pages/FourOhFour/FourOhFour";
import {MainNav} from "./shared/components/main-nav/MainNav";
import {Swipes} from "./pages/Likes/Swipes";
import {applyMiddleware, createStore} from "redux";
import thunk from "redux-thunk";
import reducers from "./shared/reducers/swipe-reducer"
import {Provider} from "react-redux";
import {Likes} from "./pages/Home/Likes";

const store = createStore(reducers,applyMiddleware(thunk));

const Routing = (store) => (
    <>
        <Provider store={store}>
            <BrowserRouter>
                <MainNav/>
                <Switch>
                    <Route exact path="/Likes" component={Likes}/>
                    <Route exact path="/Likes" component={Swipes} />
                    <Route component={FourOhFour}/>
                </Switch>
            </BrowserRouter>
        </Provider>

    </>
);
ReactDOM.render(Routing(store) , document.querySelector("#root"));