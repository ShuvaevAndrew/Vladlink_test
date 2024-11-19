<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=test', 'root', '1111');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Cant connect: ' . $e->getMessage());
}

function buildCatList($categories, $parentId = null, $level = 0) {
    $html = '';
    foreach ($categories as $category) {
        if ($category['parent_id'] == $parentId) {
            $html .= str_repeat('&nbsp', $level * 4) . htmlspecialchars($category['name']) . '<br>';
            $html .= buildCatList($categories, $category['id'], $level + 1);
        }
    }
    return $html;
}

$stmt = $pdo->query('SELECT id, name, parent_id FROM categories');
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$menulist = buildCatList($categories);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список категорий</title>
</head>
<body>
<h1>Список меню</h1>
<div>
    <?= $menulist ?>
</div>
</body>
</html>
