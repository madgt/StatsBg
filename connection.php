<?php
//Conexao Banco de Dados

	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "BggStatistics";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
// mysqli_query("SET NAMES 'utf8'");
// mysqli_query('SET character_set_connection=utf8');
// mysqli_query('SET character_set_client=utf8');
// mysqli_query('SET character_set_results=utf8');
?>