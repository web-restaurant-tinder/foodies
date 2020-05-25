import React, {useEffect} from "react";
import {useSelector, useDispatch} from "react-redux";
import {getSwipesBySwipeProfileId} from "../../shared/actions/get-swipes";
import {SwipeCard} from "../../shared/LikesCard/SwipesCard";

export const LikesData = ({match}) => {
    const dispatch = useDispatch();

    const sideEffects = () => {
        dispatch(getSwipesBySwipeProfileId(match.params.userId));
    };

    const sideEffectInputs = [match.params.userId];

    useEffect(sideEffects, sideEffectInputs);

    const swipes = useSelector(state => (
       state.swipes ? state.swipes : []
    ));

    return (
        <>
            <main className={"container"}>
                {swipes && (<h2>{swipes.name}</h2>)}
                <div className={"card-group card columns"}>
                    {swipes.map(swipes => <SwipeCard swipes={swipes} key={swipes.userId}/> )}
                </div>
            </main>
        </>
    )
}
