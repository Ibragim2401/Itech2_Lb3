<?php
try 
{
    $dsn = "mysql:host=localhost;dbname=lb_pdo_workers";
    $user = 'root';
    $pass = '';
    $dbh = new PDO($dsn, $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $ex)
{
    echo "Помилка підключення до бази даних: " . $ex->GetMessage();
}
?>