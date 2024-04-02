<?php
// Підключення до бази даних
include 'connect.php'; // Файл з налаштуваннями підключення до бази даних

// Отримання даних зі списку вибору
$project_name = $_GET['project_name']; // Припустимо, що ви передаєте дані методом GET

try {
    // SQL-запит для вибірки даних з бази даних
    $sql = "SELECT DISTINCT DATEDIFF(work.time_end, work.time_start) AS days_difference
            FROM work 
            JOIN project ON work.FID_PROJECTS = project.ID_PROJECTS
            WHERE project.name = :project_name";

    // Підготовка запиту
    $stmt = $dbh->prepare($sql);

    // Підставлення значення параметра
    $stmt->bindParam(':project_name', $project_name);

    // Виконання запиту
    $stmt->execute();

    // Отримання результатів запиту
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Формування XML-структури
    $xml = new SimpleXMLElement('<results></results>');
    foreach ($result as $row) {
        $dayNode = $xml->addChild('day');
        $dayNode->addChild('difference', $row['days_difference']);
    }

    // Встановлення заголовка Content-Type для повернення XML
    header('Content-type: text/xml');

    // Виведення XML-структури як відповідь на запит
    echo $xml->asXML();
} catch (PDOException $ex) {
    // Обробка помилок
    echo "Помилка виконання запиту: " . $ex->getMessage();
}
?>
