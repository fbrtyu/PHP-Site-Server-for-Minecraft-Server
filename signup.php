<?php
require "includes/db.php";

$data = $_POST;
if(isset($data['do_signup'])){
    //Registration
    if(trim($data['login']) == ''){
        $errors[] = 'Введите логин!';
    }

    if($data['password'] == ''){
        $errors[] = 'Введите пароль!';
    }

    if(R::count('serverusers', "realname = ?", array($data['login'])) > 0){
        $errors[] = 'Такой пользователь уже есть!';
    }

    if(empty($errors)){
        //OK, Registration
        $user = R::dispense('serverusers');
        $user -> realname = $data['login'];
        $user -> username = strtolower($data['login']);
        $user -> password = password_hash($data['password'], PASSWORD_DEFAULT);
        R::store($user);
        //echo '<div style = "color: green;">Успешная регистрация!</div><hr>';
        header('Location: /login.php');
    } else{
        echo '<div style = "color: red;">' .array_shift($errors).'</div><hr>';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styleRegLog.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MineWay</title>
</head>

<body>
    <div class="intro">
        <form class="box" action="/signup.php" method="post" id="mainform">
            <h1>Регистрация</h1>
            <a href="login.php" style="color: green">Войти</a>
            <a href="index.php" style="color: green">Главная</a>
            <input type="text" name="login" placeholder="Никнейм в игре" value="<?php echo @$data['login']; ?>">
            <input type="password" name="password" placeholder="Пароль">
            <input type="submit" name="do_signup" value="Зарегистрироваться">
        </form>
    </div>
</body>
</html>