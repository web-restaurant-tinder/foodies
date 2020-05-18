import React from "react"
import {Card, Button, Accordion,} from "react-bootstrap";
// import "app/src/pages/mystylesheet.css"

export const Choices = () => {
	return (
		<>
			<container style={{display: "block", margin: "auto", width: "63%"}}>;
				<Accordion>
					<Card className="text-center" bg={"primary"} style={{width: '20rem', height: "20rem"}}>
						<Card.Header>Frontier</Card.Header>
						<Accordion.Toggle as={Card.Header} eventKey="1">
							<Card.Img variant="top" src="https://i.ibb.co/ys2NBzW/frontier.jpg"/>
						</Accordion.Toggle>
						<Accordion.Collapse eventKey="1">
							<Card.Body>
								We are going to make placeholder text great again. Greater than ever before. You have so many
								different things placeholder text has to be able to do, and I don't believe Lorem Ipsum has the
								stamina. It’s about making placeholder text great again.You’re disgusting. I think my strongest
								asset maybe by far is my temperament. I have a placeholding temperament. All of the words in
								Lorem Ipsum have flirted with me - consciously or unconsciously. That's to be expected. I’m the
								best thing that ever happened to placeholder text.
							</Card.Body>
						</Accordion.Collapse>
					</Card>
				</Accordion>
			</container>
		</>
	)
};
