<?php
//Modifie les param�tres inscrits dans la base de donn�es
header('Content-Type: application/json');
require_once('../Settings.php');

if (isset($_POST['title']) and $_POST['title'] != '')
{
	if (isset($_POST['limit']) and $_POST['limit'] != '')
	{
		Settings::getInstance()->setTitle($_POST['title']);
		Settings::getInstance()->setLimit($_POST['limit']);

		$success = array("success");
		echo json_encode($success, JSON_PRETTY_PRINT);
		exit();
	}
	else {
		$error = array("error" , "Limit Error.");
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}
}
else {
	$error = array("error" , "Title Error.");
	echo json_encode($error, JSON_PRETTY_PRINT);
	exit();
}
?>