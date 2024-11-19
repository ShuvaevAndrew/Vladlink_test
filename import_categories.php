<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=test', 'root', '1111');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Ошибка подключения: ' . $e->getMessage());
}

$fileContents = file_get_contents('categories.json');
$data = json_decode($fileContents, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Ошибка разбора JSON: ' . json_last_error_msg());
}

function importCategories($pdo, $categories, $parentId = null) {
    foreach ($categories as $category) {
        $stmt = $pdo->prepare("INSERT INTO categories (id, name, alias, parent_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$category['id'], $category['name'], $category['alias'], $parentId]);

        if (!empty($category['childrens'])) {
            importCategories($pdo, $category['childrens'], $category['id']);
        }
    }
}

importCategories($pdo, $data);

echo "Категории успешно импортированы!\n";
