<?php
require "includes/db.php";

$data = $_POST;
if(isset($data['do_login'])){
    $errors = array();
    $user = R::findOne('serverusers', 'realname = ?', array($data['login']));
    if($user){
        if(password_verify($data['password'], $user -> password)){
            $_SESSION['logged_user'] = $user;
            //echo '<div style = "color: green;">Вы успешно вошли!<br>Перейти в ЛК <a href="/">ЛК</a></div><hr>';
            header('Location: /index.php');
        }else{
            $errors[] = 'Неверный пароль!';
        }
    }else{
        $errors[] = 'Пользователя с таким логином нет!';
    }

    if( !empty($errors)){
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
        <form class="box" action="/login.php" method="post" id="mainform">
            <h1>Войти</h1>
            <a href="signup.php" style="color: green">Регистрация</a>
            <a href="index.php" style="color: green">Главная</a>
            <input type="text" name="login" placeholder="Никнейм в игре" value="<?php echo @$data['login']; ?>">
            <input type="password" name="password" placeholder="Пароль">
            <input type="submit" name="do_login" value="Войти">
        </form>
    </div>
</body>
</html>