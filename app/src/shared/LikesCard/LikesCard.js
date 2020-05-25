import React, {useEffect} from "react";
import {getAllSwipes} from "../actions/get-swipes-profile";
import {useDispatch, useSelector} from "react-redux";
import Card from "react-bootstrap/Card";

export const SwipeCard = ({swipes}) => {

    return (
        <div className={"card text-white bg-dark mb-3"}>
            <div className={"card-body"}>
                <h4 className={"card-title"}>{swipes.title}</h4>
                <p className={"card-text"}>{swipes.id}</p>
                <p className={"card-text"}>
                    <small className={"text-muted"}>{swipes.username}</small>
                </p>
            </div>
        </div>
    )


};