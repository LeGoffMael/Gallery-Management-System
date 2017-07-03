<?php
header('Content-Type: application/json');
require_once('../Settings.php');

$categories = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT t.idTag,nameTag, COUNT(ti.idTag) AS nbElements
FROM tags t
LEFT JOIN tags_images ti ON ti.idTag=t.idTag
GROUP BY t.idTag
ORDER BY nameTag ASC");
$categories->execute();

if($categories->rowCount() == 0)
{
	$error = array("error" , $categories->errorInfo());
	echo json_encode($error, JSON_PRETTY_PRINT);
	exit();
}
else{
	$tabCategories = array();
	while ($data = $categories->fetch())
	{
		$row_array['id'] = $data['idTag'];
		$row_array['text'] = $data['nameTag'];
		$row_array['nb'] = $data['nbElements'];
		array_push($tabCategories,$row_array);
	}
	$categories->closeCursor();

	echo json_encode($tabCategories, JSON_PRETTY_PRINT);
	exit();
}
?>