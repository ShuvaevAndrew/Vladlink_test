<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=test', 'root', '1111');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Cant connect: ' . $e->getMessage());
}

function buildCategories($categories, $parentId = null, $path = ''){
    $result =[];
    foreach ($categories as $category) {
        if ($category['parent_id'] == $parentId) {
            $fullpath = $path . '/' . $category['alias'];
            $result[] = str_repeat(' ', substr_count($path, '/')) . '/' . $category['name'] . ' ' . $fullpath;
            $result = array_merge($result, buildCategories($categories, $category['id'], $fullpath));
        }
    }
    return $result;
}

$stmt = $pdo->query("SELECT id, name, alias, parent_id FROM categories");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$exportData = buildCategories($categories);

file_put_contents('type_a.txt', implode(PHP_EOL, $exportData));
echo "Successfully imported to type_a.txt\n";