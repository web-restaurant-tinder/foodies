import React from "react";
import {Card} from "react-bootstrap";
import CardDeck from "react-bootstrap/CardDeck";






export const FollowCard = (props) => {


	return (
		<>
			<CardDeck>
				<Card>
					<Card.Img className="image" variant="top" src="https://i.ibb.co/hsdRNHY/nate.jpg" />
					<Card.Body>
						<Card.Title>Nathan Ortiz</Card.Title>
					</Card.Body>
				</Card>
				<Card>
					<Card.Img className="image"  variant="top" src="https://i.ibb.co/L9B7PwM/IMG-20200513-173959-122.jpg" />
					<Card.Body>
						<Card.Title>Sara Rendon</Card.Title>
					</Card.Body>
				</Card>
				<Card>
					<Card.Img className="image"  variant="top" src="https://i.ibb.co/87CCmHw/Image-from-i-OS.jpg" />
					<Card.Body>
						<Card.Title>Francisco Gallegos</Card.Title>
					</Card.Body>
				</Card>
			</CardDeck>
			<br/>
		</>
	)
};
