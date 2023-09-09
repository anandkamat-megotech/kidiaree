<?php 

include './globals/constants_db.php';

function db_connect() {
	$dsn = DSN;
	// Instantiate your DB using the DSN, username, and password
	$dbUser = DB_USERNAME;
	$dbPass = DB_PASSWORD;
	$db = new PDO($dsn, $dbUser, $dbPass);
	return $db;
}	

function db_destroy($db){
	$db = null;
}

function query_execute($db, $sql){
	//Prepare our SQL statement,
	$statement = $db->prepare($sql);
		 
	//Execute the statement.
	$statement->execute();

	return $statement;
}

function getSingleValue($db, $sql, $parameters){
    $q = $db->prepare($sql);
    $q->execute($parameters);
    return $q->fetchColumn();
}

?> 