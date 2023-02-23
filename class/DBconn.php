<?php
require_once('cron.php');
require_once('./include/code.php');
require_once('./include/check.php');

class DBconn
{
    /**
     * @return PDO
     * подключение к бд
     */
    public static function getDB(): PDO
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "clear";
        $conn = null;

        try {

            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        } catch (Exception $e) {

            error_log('[' . date("d-m-Y H:i:s") . ' | ' . $_SERVER['HTTP_HOST'] . '] ' . $e->getMessage() . PHP_EOL, 3, __DIR__ . '/logs/db_error.log');

        }
        return $conn;
    }

    /**
     * @param $servername
     * @param $username
     * @param $password
     * @param $db
     * @return bool
     *  проверяем подключение другой базы данных
     */
    public static function tryConnection($servername, $username, $password, $db): bool
    {
        try {
            new PDO("mysql:host=$servername;dbname=$db", $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            return true;
        } catch (Exception $e) {
            error_log('[' . date("d-m-Y H:i:s") . ' ' . $_SERVER['HTTP_HOST'] . '] ' . $e->getMessage() . PHP_EOL, 3, __DIR__ . '/logs/db_error.log');
            return false;
        }
    }
    /**
     * @param int $month_count
     * @return void
     *  Удаление сообщения по времни
     */

    public static function deleteByTime(int $month_count)
    {
        $query = "Delete
                    from b_im_massage 
                    where data_create  < now() - interval " . $month_count . " month";
        try {
            $stmt = self::getDB()->prepare($query);
            $stmt->execute();
        } catch (Exception $e) {
            error_log('[' . date("d-m-Y H:i:s") . ' ' . $_SERVER['HTTP_HOST'] . '] ' . $e->getMessage() . PHP_EOL, 3, __DIR__ . '/logs/db_error.log');
        }

    }

    /**
     * @param array $users_id
     * @param int $month_count
     * @return void
     *  Удаляет сообщения по времени и пользователю
     */
    public static function deleteByTimeAndUsers(array $users_id, int $month_count)
    {
        $query = "DELETE massage
                        FROM b_im_massage as massage
                        Join b_user as user on user.id = massage.author_id
                        where user.id in ($users_id[0]";
        if (count($users_id) >= 1) {
            for ($i = 1; $i < count($users_id); $i++) {
                $query .= ", $users_id[$i]";
            }
        }
        $query .= ") and massage.data_create < now() - interval " . $month_count . " month";
        try {
            $stmt = self::getDB()->prepare($query);
            $stmt->execute();
        } catch (Exception $e) {
            error_log('[' . date("d-m-Y H:i:s") . ' ' . $_SERVER['HTTP_HOST'] . '] ' . $e->getMessage() . PHP_EOL, 3, __DIR__ . '/logs/db_error.log');
        }
    }

    /**
     * @param array $users_id
     * @param int $month_count
     * @return void
     *  Удаляет все сообщения пользователей которые не выбранны
     */
    public static function deleteByTimeAndExceptSelectedUsers(array $users_id, int $month_count)
    {
        $query = "DELETE massage
                        FROM b_im_massage as massage
                        where author_id not in ($users_id[0]";
        if (count($users_id) > 1) {
            for ($i = 1; $i < count($users_id); $i++) {
                $query .= ",$users_id[$i]";
            }
        }
        $query .= ") and massage.data_create < now() - interval " . $month_count . " month";
        try {
            $stmt = self::getDB()->prepare($query);
            $stmt->execute();
        } catch (Exception $e) {
            error_log('[' . date("d-m-Y H:i:s") . ' ' . $_SERVER['HTTP_HOST'] . '] ' . $e->getMessage() . PHP_EOL, 3, __DIR__ . '/logs/db_error.log');
        }
    }

    /**
     * @return array
     *  вывод всех пользавотелей в select
     */
    public static function getAllUsers(): array
    {
        $query = "Select * From b_user";
        $stmt = self::getDB()->prepare($query);
        $stmt->execute();
        try {
            $stmt->setFetchMode(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log('[' . date("d-m-Y H:i:s") . ' ' . $_SERVER['HTTP_HOST'] . '] ' . $e->getMessage() . PHP_EOL, 3, __DIR__ . '/logs/db_error.log');
        }
        return $stmt->fetchAll();
    }

//    Быстрое заполнение таблицы с сообщениями одной кнопкой
    public static function filling(): array
    {
        $query = "INSERT INTO b_im_massage (id, chat_id, author_id, massage, data_create, notify_event)
                    VALUES (NULL, '1', '1', 'edwcwedc', '2021-09-01 12:33:00.000000', 'dsfcsdcv'),
                           (NULL, '1', '1', 'sdsdcvv', '2023-01-29 12:33:00.000000', 'sdvvdv'),
                           (NULL, '2', '2', 'sdsdcvv', '2021-03-19 12:33:00.000000', 'sdvvdv'), 
                           (NULL, '2', '2', 'sdsdcvv', '2023-01-29 12:33:00.000000', 'sdvvdv'),
                           (NULL, '3', '3', 'sdsdcvv', '2020-03-19 12:33:00.000000', 'sdvvdv'),
                           (NULL, '3', '3', 'sdsdcvv', '2023-01-29 12:33:00.000000', 'sdvvdv'),
                           (NULL, '4', '4', 'sdsdcvv', '2022-03-19 12:33:00.000000', 'sdvvdv'),
                           (NULL, '4', '4', 'sdsdcvv', '2023-01-29 12:33:00.000000', 'sdvvdv'),
                           (NULL, '5', '5', 'fgnghfn', '2023-01-29 12:33:00.000000', 'ykkmhmg'),
                           (NULL, '5', '5', 'fdvdfvb', '2021-06-20 12:33:00.000000', 'zxbfd'),
                           (NULL, '6', '6', 'fdvdfvb', '2022-06-20 12:33:00.000000', 'zxbfd'),
                           (NULL, '6', '6', 'fdvdfvb', '2023-01-29 12:33:00.000000', 'zxbfd'),
                           (NULL, '7', '7', 'fdvdfvb', '2022-06-20 12:33:00.000000', 'zxbfd'),
                           (NULL, '7', '7', 'fdvdfvb', '2023-01-29 12:33:00.000000', 'zxbfd'),
                           (NULL, '8', '8', 'fdvdfvb', '2022-06-20 12:33:00.000000', 'zxbfd'),
                           (NULL, '8', '8', 'fdvdfvb', '2023-01-29 12:33:00.000000', 'zxbfd'),
                           (NULL, '9', '9', 'fdvdfvb', '2020-06-20 12:33:00.000000', 'zxbfd'),
                           (NULL, '9', '9', 'fdvdfvb', '2023-01-29 12:33:00.000000', 'zxbfd'),
                           (NULL, '10', '10', 'fdvdfvb', '2022-06-20 12:33:00.000000', 'zxbfd'),
                           (NULL, '10', '10', 'fdvdfvb', '2023-01-29 12:33:00.000000', 'zxbfd'),
                           (NULL, '11', '11', 'fdvdfvb', '2022-06-20 12:33:00.000000', 'zxbfd'),
                           (NULL, '11', '11', 'fdvdfvb', '2023-01-29 12:33:00.000000', 'zxbfd'),
                           (NULL, '12', '12', 'fdvdfvb', '2019-06-20 12:33:00.000000', 'zxbfd'),
                           (NULL, '12', '12', 'fdvdfvb', '2023-01-29 12:33:00.000000', 'zxbfd');";
        $stmt = self::getDB()->prepare($query);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_OBJ);
        return $stmt->fetchAll();
    }
}
