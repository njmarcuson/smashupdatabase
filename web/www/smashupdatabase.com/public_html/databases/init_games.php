<?php
// run the necessary files
require_once('../general_functions/connection.php');

// create connection
$conn = get_connection();

// da sql
$sql = "CREATE TABLE games(
	game_id VARCHAR(50),
	email VARCHAR(100) NOT NULL,
	p1_f1 VARCHAR(50),
	p1_f2 VARCHAR(50),
	p1_vp INT,
	p2_f1 VARCHAR(50),
	p2_f2 VARCHAR(50),
	p2_vp INT,
	p3_f1 VARCHAR(50),
	p3_f2 VARCHAR(50),
	p3_vp INT,
	p4_f1 VARCHAR(50),
	p4_f2 VARCHAR(50),
	p4_vp INT,
	went_first INT,
	date_inputted DATETIME,
	PRIMARY KEY (game_id),
	FOREIGN KEY (email) REFERENCES users(email)
	)";
if ($conn->query($sql) === TRUE) {
	echo "We created the table games.\r\n";
} else {
	$delete = "DROP TABLE games";
	$conn->query($delete);
	if ($conn->query($sql) === TRUE) {
		echo "We had to recreate and delete the table.\r\n";
		echo "We created the table games.\r\n";
	} else {
		echo "fail";
	}
}
?>