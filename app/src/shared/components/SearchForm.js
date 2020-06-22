import Form from "react-bootstrap/Form";
import {useDispatch} from "react-redux";
import {getProfileByProfileUserName} from "../actions/get-profile"
import * as React from "react";

export const SearchForm = (props) => {
	const dispatch = useDispatch();
	const [searchWord, setSearchWord] = React.useState();
	const searchEffect  = ()=>{
		searchWord !== undefined && dispatch(getProfileByProfileUserName(searchWord))
	};
	React.useEffect(searchEffect,[searchWord]);
	const setSearch = (event) => {
		event.preventDefault();
		console.log(searchWord)
		//check the input field for which characters are being entered and set them as the search term
		setSearchWord(event.target.value);
	};


	return (
		<>
			<container>
				<Form inline className="justify-content-end">
					<Form.Control type="text"
									  placeholder="Search by UserName"
									  id="search-text"
									  onChange={setSearch}
						// value={searchWord}

					/>
					<button type="submit" className="btn btn-primary">Search</button>
				</Form>
			</container>
		</>

	);
};