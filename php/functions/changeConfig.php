<?php
	require_once('config.php');

	$content = "<?php
/**
 * The configuration of your installation
 *
 * This file contains the configuration settings for the MySQL database
 *
 * /! \ You can modify this file directly but be careful that it corresponds to reality
 *
 * @author Maël Le Goff <legoffmael@gmail.com>
 */

// ** MySQL settings (required for PDO commands) - Your host must provide you with this information ** //
/** Name of the data base */\n";

if(isset($_POST['DB_NAME'])) {
	$content .= "define( 'DB_NAME', '".$_POST['DB_NAME']."');\n";
}
else {
	$content .= "define( 'DB_NAME', '".DB_HOST."');\n";
}

$content .= "\n/** User of the database */\n";
if(isset($_POST['DB_USER'])) {
	$content .= "define( 'DB_USER', '".$_POST['DB_USER']."');\n";
}
else {
	$content .= "define( 'DB_USER', '".DB_USER."');\n";
}

$content .= "\n/** Password of the database */\n";
if(isset($_POST['DB_PASSWORD'])) {
	$content .= "define( 'DB_PASSWORD', '".$_POST['DB_PASSWORD']."');\n";
}
else {
	$content .= "define( 'DB_PASSWORD', '');";
}

$content .= "\n/** MySQL hosting address */\n";
if(isset($_POST['DB_HOST'])) {
	$content .= "define( 'DB_HOST', '".$_POST['DB_HOST']."');\n";
}
else {
	$content .= "define( 'DB_HOST', '".DB_HOST."');\n";
}

$content .= "\n/** Character sets of the database */
define( 'DB_CHARSET', 'utf8' );
?>";

	header('Content-Type: application/json');
	try{
		$config = fopen("config.php", "w") or die("Unable to open file!");
		fwrite($config, utf8_encode($content));
		fclose($config);
	}
	catch(Exception $e){
		$error = array("error" , $e);
		echo json_encode($error, JSON_PRETTY_PRINT);
		exit();
	}
	$success = array("success");
	echo json_encode($success, JSON_PRETTY_PRINT);
	exit();
?>