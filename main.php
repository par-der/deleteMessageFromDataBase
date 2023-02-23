<?php
require_once('./class/DBconn.php');
require_once('./include/code.php');
require_once('./include/check.php');

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('log_errors', 'on');
ini_set('error_log', __DIR__ . '/logs/main_error.log');

session();
cronStart();

var_dump($_SESSION);
if (!checkHost($_SERVER['HTTP_HOST']) or isset($_POST['refresh'])) {
    header('Location: work.php');
} else {
    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8"
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Delete</title>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
                integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
              crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
    <header>
        <h1>Очистка чатов</h1>
        <a href="instruction.php">
            <button class="back-button">Инструкция</button>
        </a>
    </header>
    <form action="main.php" class="custom-form" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <?php

            if ((isset($_POST['users_id']) and !isset($_POST['del_user'])) or (!isset($_POST['users_id']) and isset($_POST['del_user']))) {
                print '<p class="error">Ошибка!</p>';
                error_log('[' . date("d-m-Y H:i:s") . '] ' . 'Ошибка, не выбран пользователь либо кнопка!' . PHP_EOL, 3, __DIR__ . '/logs/db_error.log');
            }
            ?>
            <label for="quantity">За какой период сохранять сообщения<br>(до текущей даты):</label>
            <select class="custom-select my-1 mr-sm-2" id="select-option" name="month_count">
                <option value="6" selected>за 6 месяцев</option>
                <option value="12">за 1 год</option>
                <option value="24">за 2 года</option>
                <option value="36">за 3 года</option>
                <option value="0">Удалить все сообщения</option>
            </select>
        </div>

        <div class="form-group">
            <?php
            echo '<label class="my-1 mr-2" for="multiple-select-2">Пользователи: </label>
                    <select class="custom-select my-1 mr-sm-2" size="5" id="multiple-select-2" name="users_id[]" multiple>';
            $user = DBconn::getAllUsers();
            if ($user) {
                foreach ($user as $users) {
                    echo '<option value="' . $users->id . '">' . $users->last_name . " " . $users->name . '</option>';
                }
            }
            echo '</select>';
            ?>

            <div class="container_radio">
                <input type="radio" id="option1" name="del_user" value="option_1">
                <label for="option1">Сохранить сообщения у выбранных пользователей</label>
                <input type="radio" id="option2" name="del_user" value="option_2">
                <label for="option2">Удалить сообщения у выбранных пользователей</label>
            </div>

            <div class="form-group">
                <label class="my-1 mr-2">Дата начала выполнения скрипта:</label>
                <input type="number" id="start" name="cron-start" value="0">
                <small id="passwordHelpInline" class="text-muted">
                    Через сколько месяцев будет повторный запрос?
                </small>
            </div>

        </div>
        <div class="container_button">
            <button type="submit" class="btn btn-primary my-1" name="del">
                Запустить
            </button>
            <button type="submit" class="btn btn-primary my-1 moved btn-danger" name="refresh">
                Сброс настроек
            </button>
        </div>
                                        <button class="btn btn-primary my-1" type="submit" name="filling" value="заполняет b_im_massage">
                                            заполняет таблицу b_im_massage
                                        </button>
    </form>
    </body>
    </html>
    <?php
}
