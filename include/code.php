<?php
require_once ('./class/DBconn.php');

/**
 * @return void
 * Запись данных в сессию
 */
function session(): void
{
    session_start();
    echo 'Старт сесии ';
    if (isset($_POST['del'])) {
        $_SESSION['month_count'] = $_POST['month_count'] ?? '';
        $_SESSION['users_id'] = $_POST['users_id'] ?? '';
        $_SESSION['cron-start'] = $_POST['cron-start'] ?? '';
        $_SESSION['del_user'] = $_POST['del_user'] ?? '';
    } elseif (isset($_POST['refresh'])) {
        unset($_SESSION);
    }
    if(isset($_SESSION['cron-start'])){
        //$output = shell_exec('crontab -e');
        //file_put_contents('/tmp/' . '0 0 ' . $_SESSION['cron-start'] . ' * * /usr/bin/php /var/www/project/main.php > /dev/null 2>&1');
        //var_dump($output);

        //$cron_file = 'cron_filename';
        // Create the file
        //touch($cron_file);
        // Make it writable
        //chmod($cron_file, 0777);
        // Save the cron
        //file_put_contents($cron_file, '0 0 ' . $_SESSION['cron-start'] . ' * * * /usr/bin/php /var/www/project/main.php > /dev/null 2>&1');
        // Install the cron
        //exec('crontab cron_file');

        //$r = exec('echo -e "`crontab -l`\n30 9 * * * /path/to/script" | crontab -');
        //var_dump($r);
    }
}

/**
 * Работа с логикой при нажатии кнопок
 */
if (isset($_POST['month_count'])) {
    if ((!isset($_POST['users_id']) and !isset($_POST['del_except_user']) and !isset($_POST['del_user'])) and isset($_POST['del'])) {
        DBconn::deleteByTime($_POST['month_count']);
    } elseif (isset($_POST['users_id']) and isset($_POST['del'])) {
        if ($_POST['del_user'] == 'option_1') {
            DBconn::deleteByTimeAndExceptSelectedUsers($_POST['users_id'], $_POST['month_count']);
        } elseif ($_POST['del_user'] == 'option_2') {
            DBconn::deleteByTimeAndUsers($_POST['users_id'], $_POST['month_count']);
        }
    }
}

/**
 * Переадрисация
 */
if (isset($_POST['save'])) {
    if(writeToDatabase($_POST['servername'], $_POST['username'], $_POST['password'], $_POST['database'], $_SERVER['HTTP_HOST'])){
        header('Location: main.php');
    } else{
        echo 'Error';
        header('Location: work.php');
    }
}

/**
 * @return void
 * Для тестирования приложения
 */
if (isset($_POST['filling'])) {
    DBconn::filling();
}



