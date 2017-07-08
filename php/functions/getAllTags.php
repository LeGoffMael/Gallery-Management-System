<?php
header('Content-Type: application/json');
require_once('../Settings.php');

$tags = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT t.idTag,nameTag, COUNT(ti.idTag) AS nbElements
FROM tags t
LEFT JOIN tags_images ti ON ti.idTag=t.idTag
GROUP BY t.idTag
ORDER BY nameTag ASC");
$tags->execute();

if($tags->rowCount() == 0)
{
	$error = array("error" , $tags->errorInfo());
	echo json_encode($error, JSON_PRETTY_PRINT);
	exit();
}
else{
	$tabTags = array();
	while ($data = $tags->fetch())
	{
		$row_array['id'] = $data['idTag'];
		$row_array['name'] = $data['nameTag'];
		$row_array['nb'] = $data['nbElements'];
		array_push($tabTags,$row_array);
	}
	$tags->closeCursor();

	echo json_encode($tabTags, JSON_PRETTY_PRINT);
	exit();
}
?>