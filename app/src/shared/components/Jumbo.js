import React from "react"
import {Jumbotron, Container} from "react-bootstrap";

export const Jumbo = () => {
	return (
		<>
			<Jumbotron fluid className="jumbo" >
				<Container>
					<h1 className="banner-1" style={{fontFamily: "impact", textAlign: "center",}}>YOU PICK</h1>
				</Container>
			</Jumbotron>
		</>
	)
}