<?php
// Підключення до бази даних
include 'connect.php'; // Файл з налаштуваннями підключення до бази даних

// Отримання даних з форми
$selected_date = $_GET['selected_date']; // Дата, введена користувачем у формі
$project_name = $_GET['project_name']; // Назва проекту, вибрана користувачем у формі

try {
    // SQL-запит для вибірки даних з бази даних
    $sql = "SELECT department.chief, project.manager, project.name, work.description, 
            work.time_start, work.time_end 
            FROM work 
            JOIN worker ON work.FID_WORKER = worker.ID_WORKER 
            JOIN department ON worker.FID_DEPARTMENT = department.ID_DEPARTMENT 
            JOIN project ON work.FID_PROJECTS = project.ID_PROJECTS 
            WHERE project.name = :project_name AND work.time_end < :selected_date";

    // Підготовка запиту
    $stmt = $dbh->prepare($sql);

    // Підставлення значень параметрів
    $stmt->bindParam(':project_name', $project_name);
    $stmt->bindParam(':selected_date', $selected_date);

    // Виконання запиту
    $stmt->execute();

    // Отримання результатів запиту
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Форматування результатів у текстовий вигляд
    $textResult = '';
    foreach ($result as $row) {
        $textResult .= "Chief: " . $row['chief'] . "\n";
        $textResult .= "Manager: " . $row['manager'] . "\n";
        $textResult .= "Project Name: " . $row['name'] . "\n";
        $textResult .= "Description: " . $row['description'] . "\n";
        $textResult .= "Time Start: " . $row['time_start'] . "\n";
        $textResult .= "Time End: " . $row['time_end'] . "\n\n";
    }

    // Виведення результатів у текстовому вигляді як відповідь на запит
    echo $textResult;

} catch (PDOException $ex) {
    // Обробка помилок
    echo "Помилка виконання запиту: " . $ex->getMessage();
}
?>
