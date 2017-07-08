<?php
header('Content-Type: application/json');
require_once('../Settings.php');

if (isset($_GET['value'])) {
    $categories = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT c.idCategory,nameCategory, COUNT(ci.idCategory) AS nbElements
    FROM categories c
    LEFT JOIN categories_images ci ON ci.idCategory=c.idCategory
    WHERE c.nameCategory LIKE :value
    GROUP BY c.idCategory
    ORDER BY nameCategory ASC");
    $categories->bindValue(':value', '%'.$_GET['value'].'%',PDO::PARAM_STR);
    $categories->execute();

	$tabCategories = array();
	while ($data = $categories->fetch())
	{
		$row_array['id'] = $data['idCategory'];
		$row_array['name'] = $data['nameCategory'];
		$row_array['nb'] = $data['nbElements'] + getAllImages($data['nameCategory']);;
		array_push($tabCategories,$row_array);
	}
	$categories->closeCursor();

	echo json_encode($tabCategories, JSON_PRETTY_PRINT);
	exit();
}
else {
    $error = array("No value.");
    echo json_encode($error, JSON_PRETTY_PRINT);
    exit();
}

/* Return all childs from the category */
function getAllImages($nameParent) {
    $nbImages = 0;

    if (hasChild($nameParent)) {
        $allImages = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT c1.nameCategory, COUNT(ci.idCategory) AS nbElements
        FROM categories c1
        LEFT JOIN categories_images ci ON ci.idCategory=c1.idCategory
        WHERE c1.idCategory IN
         (SELECT idChild FROM categories c2
         JOIN parent_child pc ON pc.idParent=c2.idCategory
         WHERE c2.nameCategory = :parent)
        GROUP BY c1.idCategory, c1.urlImageCategory
        ORDER BY c1.nameCategory ASC");
        $allImages->bindValue(':parent', $nameParent);
        $allImages->execute();

        while ($data = $allImages->fetch())
        {
            if($nbImages < 100) {
                $nbImages += $data['nbElements'];
                $nbImages += getAllImages($data['nameCategory']);
            }
            else {
                $nbImages = '+100';
            }
        }
        $allImages->closeCursor();
    }

    return $nbImages;
}

/* Return if the Category have child(s) */
function hasChild($nameParent) {
    $res = false;

    $hasChild = Settings::getInstance()->getDatabase()->getDb()->prepare("SELECT c1.nameCategory
	FROM categories c1
	WHERE c1.idCategory IN
		(SELECT idChild FROM categories c2
		JOIN parent_child pc ON pc.idParent=c2.idCategory
		WHERE c2.nameCategory = :parent)
	GROUP BY c1.idCategory, c1.urlImageCategory
	ORDER BY c1.nameCategory ASC");
    $hasChild->bindValue(':parent', $nameParent);
    $hasChild->execute();

    if($hasChild->rowCount() > 0) {
        $res = true;
    }

    return $res;
}
?>