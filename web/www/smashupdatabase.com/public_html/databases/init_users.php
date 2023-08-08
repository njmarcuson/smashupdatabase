<?php
// run the necessary files
require_once('../general_functions/connection.php');

// create connection
$conn = get_connection();

// da sql
$create_table = "CREATE TABLE users(
	email VARCHAR(100), 
	password VARCHAR(100) NOT NULL,
	base BOOLEAN,
	al9 BOOLEAN,
	cthulhu BOOLEAN,
	scifi BOOLEAN,
	monster BOOLEAN,
	pretty BOOLEAN,
	fault BOOLEAN,
	cease BOOLEAN,
	thinking BOOLEAN,
	japan BOOLEAN,
	seventies BOOLEAN,
	oops BOOLEAN,
	wt1 BOOLEAN,
	wt2 BOOLEAN,
	geeks BOOLEAN,
	allstars BOOLEAN,
	sheep BOOLEAN,
	penguins BOOLEAN,
	munchkin BOOLEAN,
	marvel BOOLEAN,
	goblins BOOLEAN,
	titans BOOLEAN,
	date_created DATETIME,
	PRIMARY KEY (email)
)";
if ($conn->query($create_table) === TRUE) {
	echo "We created the table users.";
} else {
	$delete = "DROP TABLE games";
	$conn->query($delete);
	$delete = "DROP TABLE users";
	$conn->query($delete);
	echo $conn->error;
	if ($conn->query($create_table) === TRUE) {
		echo "We had to recreate and delete the table.\r\n";
		echo "We created the table users.\r\n";
	} else {
		echo "fail";
		echo $conn->error;
	}
}
?>