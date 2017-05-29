<?php
//Modifie les paramètres inscrits dans la base de données
header('Content-Type: application/json');
require_once('../Settings.php');

if (isset($_POST['title']) and $_POST['title'] != '')
{
	if (isset($_POST['limit']) and $_POST['limit'] != '')
	{
		if (isset($_POST['language']) and $_POST['language'] != '')
		{
			Settings::getInstance()->setTitle($_POST['title']);
			Settings::getInstance()->setLimit($_POST['limit']);
			Settings::getInstance()->setLanguage($_POST['language']);

			$success = array("success");
			echo json_encode($success, JSON_PRETTY_PRINT);
			exit();
		}
		else {
			$error = array("error" , "Language Error.");
			echo json_encode($error, JSON_PRETTY_PRINT);
			exit();
		}
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