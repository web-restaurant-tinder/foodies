import React from "react"
import {Card, Button, Accordion,} from "react-bootstrap";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faHeart} from "@fortawesome/free-solid-svg-icons";
import {faThumbsDown} from "@fortawesome/free-solid-svg-icons";



export const UserPosts = ({match}) => {

	const dispatch = useDispatch();

	const sideEffects = () => {
		dispatch(getRestaurantByDistance(match.params.userId)); /*pass in lat long distance not match*/
		dispatch(getUserByUserId(match.params.userId));
	};

	const sideEffectInputs = [match.params.userId];

	useEffect(sideEffects, sideEffectInputs);

	const posts = useSelector(state => (
		state.posts ? state.posts : []
	));
	const user = useSelector(state => (
		state.users ? state.users[0] : null
	));



export const Choices = () => {
	return (
		<>
			<container style={{display: "block", margin: "auto", width: "62%"}}>
				<Accordion>
					<Card className="text-center" bg={"primary"} style={{width: '50rem', height: "48rem"}}>
						<Card.Header>Frontier</Card.Header>
						<Accordion.Toggle as={Card.Header} eventKey="1">
							<Card.Img variant="top" src="https://i.ibb.co/ys2NBzW/frontier.jpg"/>
						</Accordion.Toggle>
						<Accordion.Collapse eventKey="1">
							<Card.Text>
								We are going to make placeholder text great again. Greater than ever before. You have so many
								different things placeholder text has to be able to do, and I don't believe Lorem Ipsum has the
								stamina. It’s about making placeholder text great again.You’re disgusting. I think my strongest
								asset maybe by far is my temperament. I have a placeholding temperament.
							</Card.Text>
						</Accordion.Collapse>
						<button type="button" className="btn btn-danger btn-circle btn-xl"><FontAwesomeIcon size="lg" icon={faHeart}/>
						</button>
						<button type="button" className="btn btn-danger btn-circle btn-xl"><FontAwesomeIcon size="lg" icon={faThumbsDown}/>
						</button>
					</Card>
				</Accordion>
			</container>
		</>
	)
};}
