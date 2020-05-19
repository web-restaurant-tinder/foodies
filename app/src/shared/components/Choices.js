import React from "react"
import {Card, Button, Accordion,} from "react-bootstrap";
// import "app/src/pages/mystylesheet.css"

export const Choices = () => {
	return (
		<>
			<container style={{display: "block", margin: "auto", width: "55%"}}>
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
						<button type="button" className="btn btn-primary btn-circle btn-xl"><i className="fa fa-times"/>
						</button>
						<button type="button" className="btn btn-danger btn-circle btn-xl"><i className="fa fa-heart"/>
						</button>
					</Card>
				</Accordion>
			</container>
		</>
	)
};
