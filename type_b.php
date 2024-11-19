<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=test', 'root', '1111');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Ошибка подключения: ' . $e->getMessage());
}

$stmt = $pdo->query("SELECT name FROM categories WHERE parent_id IS NULL");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$exportData = array_map(fn($category) => $category['name'], $categories);

file_put_contents('type_b.txt', implode(PHP_EOL, $exportData));
echo "Successfully exported to type_b.txt\n";
