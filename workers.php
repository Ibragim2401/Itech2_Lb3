<?php
// Підключення до бази даних
include 'connect.php'; // Файл з налаштуваннями підключення до бази даних

// Отримання даних зі списку вибору
$chief_name = $_GET['chief_name']; // Припустимо, що ви передаєте дані методом GET

try {
    // SQL-запит для вибірки даних з бази даних
    $sql = "SELECT DISTINCT project.manager 
            FROM project 
            JOIN work ON project.ID_PROJECTS = work.FID_PROJECTS 
            JOIN worker ON work.FID_WORKER = worker.ID_WORKER 
            JOIN department ON worker.FID_DEPARTMENT = department.ID_DEPARTMENT 
            WHERE department.chief = :chief_name";

    // Підготовка запиту
    $stmt = $dbh->prepare($sql);

    // Підставлення значення параметра
    $stmt->bindParam(':chief_name', $chief_name);

    // Виконання запиту
    $stmt->execute();

    // Отримання результатів запиту
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Перетворення результату у формат JSON
    $jsonResult = json_encode($result, JSON_PRETTY_PRINT);

    // Вивід результату як відповідь на запит
    echo $jsonResult;
} catch (PDOException $ex) {
    // Обробка помилок
    echo "Помилка виконання запиту: " . $ex->getMessage();
}
?>
