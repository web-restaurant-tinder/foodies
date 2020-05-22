import React from "react";
import Container from "react-bootstrap/Container";
import {Accordion, Card} from "react-bootstrap";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faHeart, faThumbsDown} from "@fortawesome/free-solid-svg-icons";


export const Restaurant = ({restaurants}) => {
	let restaurant = restaurants [Math.round(Math.random() * restaurants.length - 1)];

console.log(restaurant)
	return (
		<>
			<Container style={{display: "block", margin: "auto", width: "62%"}}>
				<Accordion>
					<Card className="text-center" bg={"primary"} style={{width: '50rem', height: "48rem"}}>
						<Card.Header>{restaurant.restaurantName}</Card.Header>
						<Accordion.Toggle as={Card.Header} eventKey="1">
							<Card.Img variant="top" src={restaurant.restaurantAvatar}/>
						</Accordion.Toggle>

							<Card.Text>
								{restaurant.restaurantAddress}
								<br/>
								{restaurant.restaurantPhone}
								<br/>
								{restaurant.restaurantFoodType}
								<br/>
								{restaurant.restaurantUrl}
								<br/>
								{restaurant.restaurantStarRating}

							</Card.Text>

						<button type="button" className="btn btn-danger btn-circle btn-xl"><FontAwesomeIcon size="lg" icon={faHeart}/>
						</button>
						<button type="button" className="btn btn-danger btn-circle btn-xl"><FontAwesomeIcon size="lg" icon={faThumbsDown}/>
						</button>
					</Card>
				</Accordion>
			</Container>

		</>
	)
};