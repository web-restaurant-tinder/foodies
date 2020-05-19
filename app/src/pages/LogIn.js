import React from "react"
import "../stylesheets.css"


export const LogIn = () => {
	return (
			<card id={"signInCard"}>
			<h3>Sign In</h3>
			<div className="form-group" id="emailAddressGroup">
			<label>Email address</label>
			<input type="email" className="form-control" placeholder="Enter email" />
			</div>

			<div className="form-group" id="passwordGroup">
			<label>Password</label>
			<input type="password" className="form-control" placeholder="Enter password" />
			</div>

			<div className="form-group" id="checkBoxGroup">
			<div className="custom-control custom-checkbox">
			<input type="checkbox" className="custom-control-input" id="customCheck1" />
			<label className="custom-control-label" htmlFor="customCheck1">Remember me</label>
			</div>
			</div>
			<div className="buttonGroup">
			<button type="submit" className="btn btn-primary btn-block">Submit</button>
			<p className="forgot-password text-right" id="forgotPassword"> Forgot <a href="#">password?</a>
			</p>
			</div>
			</card>
			);
		}