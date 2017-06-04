<?php

	$servername = "localhost";
	$username = "root";
	$pswd = "root";
	$db = "hw4";

	$link = mysqli_connect($servername, $username, $pswd);
	mysqli_select_db($link, $db);

	// todecide which path to follow
	$uri = $_SERVER['REQUEST_URI'];
	$sqlData;
	$substring = substr($uri, 6);
	if($substring == "" || $substring == "/"){
		$query = "SELECT title FROM book";
		$result = mysqli_query($link, $query);
		if (mysqli_num_rows($result) <= 0) {
			$sqlData = array('error' => 'No books found!');
		}
		else{
			while($row = mysqli_fetch_assoc($result)){
				$sqlData[] = $row;
			}				
		}
	}
	else{
		$id = (int)substr($substring, 1);
		$query = "SELECT title, year, price, category, author_name
				  FROM book B, book_authors BA
				  JOIN authors A on A.author_id = BA.author_id
				  WHERE B.book_id = $id AND B.book_id = BA.book_id";
		$result = mysqli_query($link, $query);
		if (mysqli_num_rows($result) <= 0) {
			$sqlData = array('error' => 'No book found with id='. $id. '!');
		}
		else{
			while($row = mysqli_fetch_assoc($result)){
				$sqlData[] = $row;
			}				
		}

	}

	$response = json_encode($sqlData);
	echo $response;
?>