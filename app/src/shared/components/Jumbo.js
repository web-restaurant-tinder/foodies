import React from "react"
import {Jumbotron, Container} from "react-bootstrap";
export const Jumbo = () => {
	return (
		<>
			<Jumbotron fluid>
				<Container>
					<h1 style={{fontFamily: "impact", textAlign: "center"}}>YOU PICK</h1>
				</Container>
			</Jumbotron>
		</>
	)
}