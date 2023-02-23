<?php
require_once('./include/code.php');
require_once('./include/check.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <title>Document</title>
</head>
<body>
<header>
    <h1>Очистка чатов</h1>
<!--    <form action="instruction.php" method="post">-->
<!--        <button class="back-button" name="DB_instruct">Инструкция</button>-->
<!--    </form>-->
</header>

<form method="post" action="work.php" class="custom-form" enctype="multipart/form-data">
    <h3>Connect DB</h3>
    <div class="form-group">
        <label for="inputPassword5">servername:</label>
        <input type="text" value="localhost" id="inputPassword5" class="form-control" name="servername" required/>
    </div>
    <div class="form-group">
        <label for="inputPassword5">username:</label>
        <input type="text" value="root" id="inputPassword5" class="form-control" name="username" required/>
    </div>
    <div class="form-group">
        <label for="inputPassword5">password:</label>
        <input type="password" id="inputPassword5" class="form-control" name="password"/>
    </div>
    <div class="form-group">
        <label for="inputPassword5">database:</label>
        <input type="text" id="inputPassword5" class="form-control" name="database" required/>
    </div>

    <div class="container_button">
        <button type="submit" class="btn btn-primary my-1" name="save">
            Подключение
        </button>
    </div>
</form>
</body>
</html>
