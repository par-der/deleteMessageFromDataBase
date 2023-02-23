<?php
require_once('./class/DBconn.php');

/**
 * @param $servername
 * @param $username
 * @param $password
 * @param $db
 * @param $host
 * @return bool
 * Записываем данные о бд, если они корректные то мы обновляем значения
 */
function writeToDatabase($servername, $username, $password, $db, $host): bool
{
    if (DBconn::tryConnection($servername, $username, $password, $db)) {
        if (checkHost($host)) {
            $query = "Update data set server = :servername , user = :username, db = :db, pass = :password
                            where host = :host";
        } else {
            $query = "INSERT INTO data (server, user, db, host, pass) VALUES (:servername, :username, :db, :host, :password)";
        }
        try {
            $conn = new PDO("mysql:host=localhost;dbname=database", 'root', '');
            $stmt = $conn->prepare($query);
            $stmt->bindValue('servername', $servername);
            $stmt->bindValue('username', $username);
            $stmt->bindValue('password', $password);
            $stmt->bindValue('db', $db);
            $stmt->bindValue('host', $host);
            $stmt->execute();
            $conn = null;
        } catch (PDOException $e) {
            error_log('[' . date("d-m-Y H:i:s") . ' ' . $_SERVER['HTTP_HOST'] . '] ' . $e->getMessage() . PHP_EOL, 3, __DIR__ . '/logs/db_error.log');
        }
        return true;
    }
    return false;
}

/**
 * @param $host
 * @return bool
 * Проверяем на корректный host
 */
function checkHost($host): bool
{
    try {
        $conn = new PDO("mysql:host=localhost;dbname=database", 'root', '');
        $query = "Select host from data where host = :host";
        $stmt = $conn->prepare($query);
        $stmt->bindValue('host', $host);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $conn = null;
        if (count($result) <= 0) {
            return false;
        } else {
            return true;
        }
    } catch (PDOException $e) {
        error_log('[' . date("d-m-Y H:i:s") . ' ' . $_SERVER['HTTP_HOST'] . '] ' . $e->getMessage() . PHP_EOL, 3, __DIR__ . '/logs/db_error.log');
        return false;
    }
}

