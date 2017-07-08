<?php
header('Content-Type: application/json');
require_once('../Settings.php');

if (isset($_GET['value'])) {
    $tags = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT t.idTag,nameTag, COUNT(ti.idTag) AS nbElements
    FROM tags t
    LEFT JOIN tags_images ti ON ti.idTag=t.idTag
    WHERE t.nameTag LIKE :value
    GROUP BY t.idTag
    ORDER BY nameTag ASC");
    $tags->bindValue(':value', '%'.$_GET['value'].'%',PDO::PARAM_STR);
    $tags->execute();

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
}
else {
    $error = array("No value.");
    echo json_encode($error, JSON_PRETTY_PRINT);
    exit();
}
?>